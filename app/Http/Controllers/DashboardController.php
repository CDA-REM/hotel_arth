<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getOperationalDashboardData()
    {
        //
    }

        /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
         */
    public function getTacticalDashboardData()
    {
       //
    }

    /**
     * Display a listing of reservations taken between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public function getReservationsBetweenDates(Request $request): JsonResponse
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reservations = Reservation::whereBetween('started_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get();

        return response()->json($reservations);
//        return $reservations;
    }

    /**
     * Return the total sales between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public function totalSalesBetweenDates(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get();

            $totalSales = 0;

            foreach ($reservations as $reservation) {
                $totalSales += $reservation->price;
            }

            return response()->json(['total_sales' => $totalSales]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the average cart value between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public function averageCartValueBetweenTwoDates(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get();

            $cartValues = [];

            foreach ($reservations as $reservation) {
                $date = Carbon::parse($reservation->started_date)->format('d-m-Y');
                $cartValue = $reservation->price;

                if (isset($cartValues[$date])) {
                    $cartValues[$date]['value'] += $cartValue;
                    $cartValues[$date]['count']++;
                } else {
                    $cartValues[$date] = ['value' => $cartValue, 'count' => 1];
                }
            }

            $averageCartValues = [];

            foreach ($cartValues as $date => $values) {
                $averageValue = $values['value'] / $values['count'];
                $averageCartValues[] = ['date' => $date, 'cartValue' => $averageValue];
            }

            return response()->json($averageCartValues);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid input.'], 400);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error.'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    /**
     * Return the number of reservations between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public function totalReservationsBetweenDates(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $totalReservations = Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->count();

            return response()->json(['total_reservations' => $totalReservations]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid input.'], 400);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error.'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    /**
     * Return the occupancy rate between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public function occupancyRateBetweenDates(Request $request): JsonResponse
    {
        try {
            $this->validate($request, [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ]);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $totalReservations = Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->count();

            $occupancyRate = ($totalReservations / (32 * $this->calculateDaysDifference($startDate, $endDate))) * 100;

            return response()->json(['occupancy_rate' => $occupancyRate]);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'Invalid input.'], 400);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error.'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'An error occurred.'], 500);
        }
    }

    /**
     * Return the number of reservations between two dates.
     * @param $startDate
     * @param $endDate
     * @return bool|int
     * @throws Exception
     */
    private function calculateDaysDifference($startDate, $endDate): bool|int
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = $start->diff($end);
        return $interval->days;
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
