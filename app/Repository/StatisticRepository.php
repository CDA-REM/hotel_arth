<?php

namespace App\Repository;

use App\Http\Resources\StatisticResource;use App\Models\Statistic;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
class StatisticRepository {
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
}
