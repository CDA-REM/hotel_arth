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
     * Display a listing of the statistics of all the keycards sorted by key_card_id.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $statistics = Statistic::orderBy('key_card_id')->paginate(10);
        } catch (Exception $e) {
            Log::error("A database error occured : {$e->getMessage()}");
            return Response::json($e->getMessage(), 404);
        }
        // Return the collection of resources and a custom 200 message
        return response()->json([
            'data' => StatisticResource::collection($statistics),
            'message' => 'Liste des statistiques des keycards',
            'status' => 200
        ]);
    }

    /**
     * Display the statistics for the specified keycard.
     *
     * @param int $key_card_id
     * @return StatisticResource
     */
    public function show(int $key_card_id): StatisticResource
    {
        return StatisticResource::make(Statistic::where('key_card_id', $key_card_id)->firstOrFail());
    }
}
