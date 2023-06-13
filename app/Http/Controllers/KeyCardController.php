<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeyCardRequest;
use App\Http\Requests\UpdateKeyCardRequest;
use App\Http\Resources\KeyCardResource;
use App\Models\KeyCard;
use App\Repository\StatisticRepository;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KeyCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return KeyCardResource::collection(
            KeyCard::with('room_id')->paginate(10)
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $keyCard = new KeyCard;
            $keyCard->room_id = $request->room_id;
            $keyCard->reservation_id = $request->reservation_id;
            $keyCard->key_code = Str::uuid();

            $keyCard->save();

            // Create a statistic for this key card
            StatisticRepository::createStatistic($keyCard->id);

        } catch (Exception $e) {
            Log::error("A database error occured : {$e->getMessage()}");
            return Response::json($e->getMessage(), 502);
        }

        $resource = KeyCardResource::make(KeyCard::findorFail($keyCard->id));
        return response()->json($resource, 201);
    }

    public function store(StoreKeyCardRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|integer',
            'reservation_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param KeyCard $keyCard
     * @return KeyCardResource
     */
    public function show(KeyCard $keyCard): KeyCardResource
    {
        return new KeyCardResource($keyCard);
    }

    /**
     * Display the specified resource.
     *
     * @param KeyCard $keyCard
     * @return Collection|array
     */
    public function showWithReservation(KeyCard $keyCard): Collection|array
    {
        return $keyCard->with(['room.reservations'])->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateKeyCardRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateKeyCardRequest $request, int $id): JsonResponse
    {
        $keyCard = KeyCardResource::make(KeyCard::query()->findOrFail($id));
        $keyCard->update($request->post());

        return response()->json($keyCard, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(Request $request, int $id)
    {
        $keyCard = KeyCard::make(KeyCard::query()->findOrFail($id));
        $keyCard->delete($request->post());
    }
}
