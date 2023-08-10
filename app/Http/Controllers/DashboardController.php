<?php

namespace App\Http\Controllers;


use App\Repository\DashboardTacticRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Repository\DashboardRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use App\Repository\DashboardTacticRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Resources\DashboardOperationalTableResource;
use App\Repository\ReservationRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getOperationalDashboardTableData()
    {
        $collection = ReservationRepository::getFormattedReservationsByDate(today()->toDateString());

        return $collection;
    }

    /**
     * Return the total number of people for a day.
     *
     * @return array
     */
    public function getNumberOfPeople() {
        return ReservationRepository::getReservationsTotalNumberOfPeople(today()->toDateString());
    }

    /**
     * Return the total number of people for a day.
     *
     * @return array
     */
    public function getReservationsMenusOptions() {
        return ReservationRepository::getReservationsMenusByDate(today()->toDateString());
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStrategicalDashboardData(Request $request): \Illuminate\Http\JsonResponse
    {
        // Validation of parameters
        $validatedData = Validator::make($request->all(), [
            'first_period' => 'required',
            'second_period' => 'required',
        ]);
        $firstPeriodArray = DashboardRepository::getPeriod($request->get('first_period'));
        $secondPeriodArray = DashboardRepository::getPeriod($request->get('second_period'));



        // if validation fails
        if ($validatedData->fails())
        {
            return response()->json([
                'errors' => $validatedData->errors(),
            ], 400);
        }

         // Sales calculation
        $pricesOnFirstPeriod = DashboardRepository::getAllSalesInSelectedPeriod($firstPeriodArray);
        $pricesOnSecondPeriod = DashboardRepository::getAllSalesInSelectedPeriod($secondPeriodArray);

        $salesOnFirstPeriod = round(DashboardRepository::sumOfSales($pricesOnFirstPeriod), 2);
        $salesOnSecondPeriod = round(DashboardRepository::sumOfSales($pricesOnSecondPeriod), 2);


        // Number of reservations
        $reservationsOnFirstPeriod = DashboardRepository::getNumberOfReservations($firstPeriodArray);
        $reservationsOnSecondPeriod = DashboardRepository::getNumberOfReservations($secondPeriodArray);

        // Time average between reservation date and check-in
//        $averageTimeOnFirstPeriod = DashboardRepository::averageTimeReservationCheckin($firstPeriodArray);

        // Filling rate
//        $test = DashboardRepository::fillingRate($firstPeriodArray);
        //return response()->json([
//    'test' => $averageTimeOnFirstPeriod
//]);
//        dd($averageTimeOnFirstPeriod);

//        return response()->json([
//            'sales' => [
//                'first_period' => $salesOnFirstPeriod,
//                'second_period' => $salesOnSecondPeriod
//            ],
//            'reservationsNumber' => [
//                'first_period' => $reservationsOnFirstPeriod,
//                'second_period' => $reservationsOnSecondPeriod
//            ]
//        ], 200);
    }

}
