<?php

namespace App\Repository;

use App\Http\Resources\StatisticResource;use App\Models\Statistic;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

/**
 * Contains all the logic for the statistics
 * These methods can be called from any controller
 * Class StatisticRepository
 * @package App\Repository
 */
class StatisticRepository {

    /**
     * Create a statistic for a keycard when a keycard is created
     * @param int $key_card_id
     * @return JsonResponse
     */
    static function createStatistic(int $key_card_id): JsonResponse
    {
        try {
            $statistic = new Statistic;
            $statistic->key_card_id = $key_card_id;
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
     * Get the statistics for a keycard
     * @param int $key_card_id
     * @return JsonResponse
     * @throws Exception
     */
    public static function getStatistic(int $key_card_id): JsonResponse
    {
        try {
            $statistic = Statistic::where('key_card_id', $key_card_id)->firstOrFail();
        } catch (Exception $e) {
            Log::error("A database error occured : {$e->getMessage()}");
            return Response::json($e->getMessage(), 502);
        }

        $resource = StatisticResource::make($statistic);
        return response()->json($resource, 200);
    }

    /**
     * Update the statistics for a keycard each time it opens a door.
     * @param int $key_card_id
     * @return JsonResponse
     * @throws Exception
     */
    public static function updateStatistic(int $key_card_id): JsonResponse
    {
        try {
            // Retrieve the statistic for this keycard
            $statistic = Statistic::where('key_card_id', $key_card_id)->firstOrFail();
            // Retrieve the traceability array
            $traceability = json_decode($statistic->traceability);
            // Push the current datetime in the array
            $traceability[] = now('Europe/Paris')->format('Y-m-d H:i:s');
            $statistic->traceability = json_encode($traceability);
            $statistic->save();
        } catch (Exception $e) {
            Log::error("A database error occured : {$e->getMessage()}");
            return Response::json($e->getMessage(), 502);
        }

        $resource = StatisticResource::make($statistic);
        return response()->json($resource, 200);
    }

}
