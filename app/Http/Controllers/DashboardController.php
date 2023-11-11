<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationBetweenDatesRequest;
use App\Repository\DashboardTacticRepository;
use App\Repository\DashboardRepository;
use App\Repository\ReservationRepository;
use App\Services\DashboardTacticService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\DashboardOperationalTableResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Exception;

class DashboardController extends Controller
{
    protected DashboardTacticService $dashboardTacticService;

    public function __construct(DashboardTacticService $dashboardTacticService)
    {
        $this->dashboardTacticService = $dashboardTacticService;
    }
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
     * Retrieves reservations between two dates and returns them as a JSON response.
     *
     * @param ReservationBetweenDatesRequest $request the request object containing the start and end dates
     * @throws Exception if an error occurs during the retrieval process
     * @return JsonResponse the JSON response containing the reservations
     */
    public function getReservationsBetweenTwoDates(ReservationBetweenDatesRequest $request) : JsonResponse
    {
        try {
            $reservations = DashboardTacticRepository::getReservationsForPeriod($request->start_date, $request->end_date);
            return response()->json([
                'reservations' => ReservationResource::collection($reservations)
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Retrieves the total sales between two specified dates.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs while calculating the total sales.
     * @return JsonResponse The JSON response containing the total sales rounded to two decimal places.
     */
    public function getTotalSalesBetweenTwoDates(ReservationBetweenDatesRequest $request): JsonResponse
    {
        try {
            // The form request has already validated this data
            $totalSales = $this->dashboardTacticService->calculateTotalSales($request->start_date, $request->end_date);

            return response()->json(['total_sales' => round($totalSales, 2)]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Retrieves the average cart value between two dates.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs while calculating the average cart value.
     * @return JsonResponse The JSON response containing the average cart value.
     */
    public function getAverageCartValueBetweenTwoDates(ReservationBetweenDatesRequest $request): JsonResponse
    {
        try {
            $averageCartValue = $this->dashboardTacticService->calculateAverageCartValue($request->start_date, $request->end_date);

            return response()->json(['average_cart' => $averageCartValue]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Retrieves the average cart evolution between two dates.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs during the calculation.
     * @return JsonResponse The JSON response containing the average cart evolution.
     */
    public function getAverageCartEvolutionBetweenTwoDates(ReservationBetweenDatesRequest $request): JsonResponse
    {
        try {
            $averageCartEvolution = $this->dashboardTacticService->calculateAverageCartEvolution($request->start_date, $request->end_date);

            return response()->json(['average_cart_evolution' => $averageCartEvolution]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Retrieves the total number of reservations between two dates.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs during the calculation.
     * @return JsonResponse The JSON response containing the total number of reservations.
     */
    public function getNumberOfReservationsBetweenTwoDates(ReservationBetweenDatesRequest $request) : JsonResponse
    {
        try {
            $numberOfReservations = $this->dashboardTacticService->calculateNumberOfReservations($request->start_date, $request->end_date);

            return response()->json(['total_reservations' => $numberOfReservations]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Retrieves the occupancy rate between two specified dates.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs during the calculation.
     * @return JsonResponse The JSON response containing the occupancy rate.
     */
    public function getOccupancyRateBetweenTwoDates(ReservationBetweenDatesRequest $request) : JsonResponse
    {
        try {
            $occupancyRate = $this->dashboardTacticService->calculateOccupancyRate($request->start_date, $request->end_date);

            return response()->json(['occupancy_rate' => $occupancyRate]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Retrieves the occupancy rate per room type between two given dates.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs while calculating the occupancy rate.
     * @return JsonResponse The JSON response containing the occupancy rate per room type.
     */
    public function getOccupancyRatePerRoomTypeBetweenTwoDates(ReservationBetweenDatesRequest $request) : JsonResponse
    {
        try {
            $occupancyRatePerRoomType = $this->dashboardTacticService->calculateOccupancyRatePerRoomType($request->start_date, $request->end_date);

            return response()->json(['occupancy_rate_per_room_type' => $occupancyRatePerRoomType]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Retrieves the occupancy rate per option between two given dates.
     *
     * @param ReservationBetweenDatesRequest $request The request containing the start and end dates.
     * @throws Exception If an error occurs during the calculation.
     * @return JsonResponse The JSON response containing the occupancy rate per option.
     */
    public function getOccupancyRatePerOptionBetweenTwoDates(ReservationBetweenDatesRequest $request) : JsonResponse
    {
        try {
            $occupancyRatePerOption = $this->dashboardTacticService->calculateOccupancyRatePerOption($request->start_date, $request->end_date);

            return response()->json(['occupancy_rate_per_option' => $occupancyRatePerOption]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Calculate the average time between booking and check-in for a given date range.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs while calculating the average time.
     * @return JsonResponse The JSON response containing the average time between booking and check-in.
     */
    public function getAverageTimeBetweenBookingAndCheckin(ReservationBetweenDatesRequest $request) : JsonResponse
    {
        try {
            $averageTimeBetweenBookingAndCheckin = $this->dashboardTacticService->calculateAverageTimeBetweenBookingAndCheckin($request->start_date, $request->end_date);

            return response()->json(['average_time_between_booking_and_checkin' => $averageTimeBetweenBookingAndCheckin]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Retrieves the average duration of a stay based on the provided reservation dates.
     *
     * @param ReservationBetweenDatesRequest $request The request object containing the start and end dates.
     * @throws Exception If an error occurs during the calculation.
     * @return JsonResponse The JSON response containing the average duration of a stay.
     */
    public function getAverageDurationOfAStay(ReservationBetweenDatesRequest $request):JsonResponse
    {
        try {
            $averageDurationOfAStay = $this->dashboardTacticService->calculateAverageDurationOfAStay($request->start_date, $request->end_date);

            return response()->json(['average_duration_of_a_stay' => $averageDurationOfAStay]);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
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
