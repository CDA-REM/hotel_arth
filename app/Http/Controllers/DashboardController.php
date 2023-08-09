<?php

namespace App\Http\Controllers;

use App\Repository\DashboardTacticRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function getOperationalDashboardData()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function getTacticalDashboardData()
    {
        //
    }

    /**
     * Return a listing of the reservations between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getReservationsBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::reservationsBetweenDates($request);
    }

    /**
     * Return the total sales between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getTotalSalesBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::totalSalesBetweenDates($request);
    }

    /**
     * Return the average cart between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getAverageCartValueBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::averageCartValueBetweenTwoDates($request);
    }

    /**
     * Return the total number reservations between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getNumberOfReservationsBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::numberOfReservationsBetweenDates($request);
    }

    /**
     * Return the occupancy rate between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getOccupancyRateBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::occupancyRateBetweenDates($request);
    }

    /**
     * Return the occupancy rate per room type between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getOccupancyRatePerRoomTypeBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::occupancyRatePerRoomTypeBetweenDates($request);
    }

    /**
     * Return the occupancy rate per option between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getOccupancyRatePerOptionBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::occupancyRatePerOptionBetweenDates($request);
    }

    /**
     * Return the average time between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getAverageTimeBetweenBookingAndCheckin(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::averageTimeBetweenBookingAndCheckin($request);
    }

    /**
     * Return the average duration of a reception, using the repository.
     * @param Request $request
     * @return JsonResponse
     */

    public function getAverageDurationOfAReception(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::averageDurationOfAReception($request);
    }





        /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getStrategicalDashboardData()
    {
        //
    }
}
