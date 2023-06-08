<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAvailableRoomsRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Http\Validators\ReservationControllerValidator;
use App\Models\Reservation;
use App\Repository\ReservationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function createReservation(Request $request) : JsonResponse
    {
        // Data validation
        $validator = ReservationControllerValidator::createReservationValidator($request);
        if($validator->fails())
        {
            Log::error($validator->errors());
            return Response::json($validator->errors(), 502);
        }
        $validated = $validator->validated();

        // Creating an array with room ids
        $rooms = [ ...ReservationRepository::getAvailableRooms($validated["started_date"], $validated["end_date"])
                                         ->where("style", '==', $validated["roomCategory"])
                                         ->take($validated["numberOfRooms"])
                                         ->pluck("id") ];

        // Creating the reservation
        $reservation = new Reservation;
        $reservation->price = ReservationRepository::calculateReservationPrice($validated, $rooms);
        $reservation->started_date = $validated["started_date"];
        $reservation->end_date = $validated["end_date"];
        $reservation->number_of_people = $validated["numberOfPeople"];
        $reservation->stay_type = $validated["isTravelForWork"] ? "pro" : "personal";
        $reservation->user_id = $validated["user_id"];
        $reservation->status = "validated";
        $reservation->save();

        $reservation->rooms()->attach($rooms);

        if ($validated["formOptions"] !== []) {
            $reservation->options()->attach($validated["formOptions"]);
        }

        $resource = ReservationResource::make(Reservation::findOrFail($reservation->id));

        return response()->json($resource);
    }


    /**
     * Display the specified resource.
     *
     * @return \App\Http\Resources\ReservationResource
     */
    public function show(int $id) : ReservationResource
    {
        return ReservationResource::make(Reservation::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->post(), [
            'status' => 'string|in:validated,cancelled,no-show,terminated'
                ]
        );

        $validated = $validator->validated();

        $resource = ReservationResource::make(Reservation::findOrFail($id));

        $resource->update($validated);

        return response()->json($resource);
    }

    /**
     * @param Request $request
     * @mixin Reservation
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getAvailableRoomsFromRequest(Request $request) : Collection | Response
    {
        // Data validation
        $validator = ReservationControllerValidator::getAvailableRoomsValidator($request);
        if($validator->fails())
        {
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $reservation = Reservation::find($id);
        $reservation->rooms()->detach();
        $reservation->options()->detach();
        $reservation->delete();
    }
}
