<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKeyCardRequest;
use App\Http\Requests\UpdateKeyCardRequest;
use App\Http\Resources\KeyCardResource;
use App\Models\KeyCard;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

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
     * @return Response
     */
    public function create(Request $request) : JsonResponse
    {
        try {
            $keyCard = new KeyCard;
            $keyCard->room_id = $request->room_id;
            $keyCard->key_code = $request->key_code;

            $keyCard->room;

            $keyCard->save();
        } catch (Exception $e) {
            Log::error("A database error occured : {$e->getMessage()}");
            return Response::json($e->getMessage(), 502);
        }

        $resource = KeyCardResource::make(KeyCard::findorFail($keyCard->id));
        return response()->json($resource, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreKeyCardRequest $request
     * @return Response
     */
    public function store(StoreKeyCardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KeyCard  $keyCard
     * @return Response
     */
    public function show(int $id) : KeyCardResource
    {
        return KeyCardResource::make(KeyCard::query()->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateKeyCardRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(UpdateKeyCardRequest $request, int $id) : JsonResponse
    {
        $keyCard = KeyCardResource::make(KeyCard::query()->findOrFail($id));
        $keyCard->update($request->post());

        return response()->json($keyCard, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(Request $request, int $id)
    {
        $keyCard = KeyCard::make(KeyCard::query()->findOrFail($id));
        $keyCard->delete($request->post());
    }
}
