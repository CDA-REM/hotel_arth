<?php

namespace App\Http\Controllers;

use App\Repository\DashboardTacticRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Repository\DashboardRepository;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\DashboardOperationalTableResource;
use App\Repository\ReservationRepository;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getOperationalDashboardTableData(): array
    {
        return ReservationRepository::getFormattedReservationsByDate(today()->toDateString());
    }

    /**
     * Return the total number of people for a day.
     *
     * @return float|int
     */
    public function getNumberOfPeople(): float|int
    {
        return ReservationRepository::getReservationsTotalNumberOfPeople(today()->toDateString());
    }

    /**
     * Return the total number of people for a day.
     *
     * @return array
     */
    public function getReservationsMenusOptions(): array
    {
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
        return DashboardTacticRepository::reservations($request);
    }

    /**
     * Return the total sales between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getTotalSalesBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::totalSales($request);
    }

    /**
     * Return the total average cart value between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getAverageCartValueBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::averageCartValue($request);
    }

    /**
     * Return the average cart between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getAverageCartEvolutionBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::averageCartEvolution($request);
    }

    /**
     * Return the total number reservations between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getNumberOfReservationsBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::numberOfReservations($request);
    }

    /**
     * Return the occupancy rate between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getOccupancyRateBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::occupancyRate($request);
    }

    /**
     * Return the occupancy rate per room type between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getOccupancyRatePerRoomTypeBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::occupancyRatePerRoomType($request);
    }

    /**
     * Return the occupancy rate per option between two dates, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getOccupancyRatePerOptionBetweenTwoDates(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::occupancyRatePerOption($request);
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
     * Return the average duration of a checkin process, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getAverageDurationOfACheckin(Request $request) : JsonResponse
    {
        return DashboardTacticRepository::averageDurationOfACheckin($request);
    }

    /**
     * Return the average duration of a stay, using the repository.
     * @param Request $request
     * @return JsonResponse
     */
    public function getAverageDurationOfAStay(Request $request):JsonResponse
    {
        return DashboardTacticRepository::averageDurationOfAStay($request);
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function getStrategicalDashboardData(Request $request): JsonResponse
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
