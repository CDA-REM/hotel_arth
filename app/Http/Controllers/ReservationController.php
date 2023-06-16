<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Http\Validators\ReservationControllerValidator;
use App\Models\Reservation;
use App\Repository\MailRepository;
use App\Repository\ReservationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\ValidationException;
use PDOException;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * //  * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ReservationResource::collection(Reservation::all());
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function createReservation(Request $request): JsonResponse
    {
        // Data validation
        $validator = ReservationControllerValidator::createReservationValidator($request);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Response::json($validator->errors(), 502);
        }
        $validated = $validator->validated();

        // Creating an array with room ids
        $rooms = [...ReservationRepository::getAvailableRooms($validated["started_date"], $validated["end_date"])
            ->where("style", '==', $validated["roomCategory"])
            ->take($validated["numberOfRooms"])
            ->pluck("id")];

        try {
            // Creating the reservation
            $reservation = new Reservation;
            $reservation->price = ReservationRepository::calculateReservationPrice($validated, $rooms);
            $reservation->started_date = $validated["started_date"];
            $reservation->end_date = $validated["end_date"];
            $reservation->number_of_people = $validated["numberOfPeople"];
            $reservation->stay_type = $validated["isTravelForWork"] ? "pro" : "personal";
            $reservation->user_id = Auth::user()->id;
            $reservation->status = "validated";
            $reservation->save();
            $reservation->rooms()->attach($rooms);
            if ($validated["formOptions"] !== []) {
                $reservation->options()->attach($validated["formOptions"]);
            }

            MailRepository::sendMail($reservation);

        } catch (PDOException $e) {
            // Catching database exception
            Log::error("A database error occured : {{$e}}");
        } catch (Exception $e) {
            Log::error($e);
        }

        $resource = ReservationResource::make(Reservation::findOrFail($reservation->id));

        return response()->json($resource, 201);
    }


    /**
     * Display the specified resource.
     * @param int $id
     * @return ReservationResource
     */
    public function show(int $id): ReservationResource
    {
        return ReservationResource::make(Reservation::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     * @throws ValidationException
     */
//    public function update(Request $request, int $id): JsonResponse
//    {
//        //
//    }

    /**
     * Update Reservation status to in_progress and add checkin date
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function Checkin(Reservation $reservation): JsonResponse
    {
        try {
            $reservation = Reservation::findOrFail($reservation->id);
            $reservation->status = "in_progress";
            $reservation->checkin = now();
            $reservation->update();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json($e, 500);
        }
        return response()->json($reservation, 200);
    }

    /**
     * Update Reservation status to terminated and add checkout date
     * @param Reservation $reservation
     * @return JsonResponse
     */
    public function Checkout(Reservation $reservation): JsonResponse
    {
        try {
            $reservation = Reservation::findOrFail($reservation->id);
            $reservation->status = "terminated";
            $reservation->checkout = now();
            $reservation->update();
        } catch (Exception $e) {
            Log::error($e);
            return response()->json($e, 500);
        }
        return response()->json($reservation, 200);
    }

    /**
     * @param Request $request
     * @mixin Reservation
     * @return JsonResponse|Collection
     * @throws ValidationException
     */
    public function getAvailableRoomsFromRequest(Request $request): Collection|Response
    {
        // Data validation
        $validator = ReservationControllerValidator::getAvailableRoomsValidator($request);
        if ($validator->fails()) {
            Log::error($validator->errors());
            return Response::json($validator->errors(), 502);
        }

        $validated = $validator->validated();
        $started_date = $validated["started_date"];
        $end_date = $validated["end_date"];

        return ReservationRepository::getAvailableRooms($started_date, $end_date);
    }

    /**
     * Remove the specified resource and its references in the pivot tables from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $reservation = Reservation::find($id);
        $reservation->rooms()->detach();
        $reservation->options()->detach();
        $reservation->delete();

        return response()->json(['message' => 'Reservation supprimée'], 204);
    }

    public function test(int $id)
    {
        $reservation = Reservation::findOrFail($id);
        dd($reservation->user);
    }
}
