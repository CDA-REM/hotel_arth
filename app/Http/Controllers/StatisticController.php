<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatisticRequest;
use App\Http\Requests\UpdateStatisticRequest;
use App\Http\Resources\StatisticResource;
use App\Models\Statistic;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class StatisticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return StatisticResource::collection(
            Statistic::with('key_card_id')->paginate(10)
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
            $statistic = new Statistic;
            $statistic->key_card_id = $request->key_card_id;
            $statistic->traceability = json_encode([]);
            $statistic->save();

        } catch (Exception $e) {
            Log::error("A database error occured : {$e->getMessage()}");
            return Response::json($e->getMessage(), 502);
        }

        $resource = StatisticResource::make(Statistic::findorFail($statistic->id));
        return response()->json($resource, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $key_card_id
     * @return StatisticResource
     */
    public function show(int $key_card_id): StatisticResource
    {
        return StatisticResource::make(Statistic::where('key_card_id', $key_card_id)->firstOrFail());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateStatisticRequest $request
     * @param int $key_card_id
     * @return StatisticResource
     */
    public function update(int $key_card_id, UpdateStatisticRequest $request): StatisticResource
    {
        $statistic = Statistic::where('key_card_id', $key_card_id)->firstOrFail();
        $traceability = json_decode($statistic->traceability);
        array_push($traceability, $request->opening_time);
        log::info($traceability);
        dd(json_decode($traceability));


        return StatisticResource::make(Statistic::findOrFail($statistic->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Statistic $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statistic $statistic)
    {
        //
    }
}
