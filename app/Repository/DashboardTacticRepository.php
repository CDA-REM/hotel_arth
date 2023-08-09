<?php

namespace App\Repository;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Room;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;

class DashboardTacticRepository
{
    /**
     * Validate the data sent by the user.
     * @param Request $request
     * @return ValidationValidator|JsonResponse
     */
    private static function validateData(Request $request): ValidationValidator|JsonResponse
    {
        $validateData = Validator::make($request->all(),
            [
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
            ],
            [
                'required' => 'The :attribute field is required.',
            ]
        );

        if ($validateData->fails()) {
            return response()->json(['error' => $validateData->errors()], 400);
        }

        return response()->json(['success' => 'Data is valid.'], 200);
    }

    /**
     * Display a listing of reservations taken between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function reservationsBetweenDates(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());

            return response()->json($reservations);
        } catch (ValidationException) {
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException) {
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception) {
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the total sales between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function totalSalesBetweenDates(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());

            $totalSales = 0;

            foreach ($reservations as $reservation) {
                $totalSales += $reservation->price;
            }

            return response()->json(['total_sales' => $totalSales]);
        } catch (ValidationException) {
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException) {
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception) {
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the average cart value between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function averageCartValueBetweenTwoDates(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());

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
        } catch (ValidationException) {
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException) {
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception) {
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the number of reservations between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function numberOfReservationsBetweenDates(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $totalReservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get()
            )->count();

            return response()->json(['total_reservations' => $totalReservations]);
        } catch (ValidationException) {
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException) {
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception) {
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the occupancy rate between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function occupancyRateBetweenDates(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $totalReservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])->get())->count();

            $numberOfRooms = Room::all()->count();

            $occupancyRate = ($totalReservations/ ($numberOfRooms * DashboardTacticRepository::calculateDaysDifference($startDate, $endDate))) * 100;

            return response()->json(['occupancy_rate' => $occupancyRate]);
        } catch (ValidationException) {
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException) {
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the number of reservations between two dates.
     * @param $startDate
     * @param $endDate
     * @return bool|int
     * @throws Exception
     */
    private static function calculateDaysDifference($startDate, $endDate): bool|int
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = $start->diff($end);
        return $interval->days;
    }

    public static function occupancyRatePerRoomTypeBetweenDates($request): JsonResponse
    {
        DashboardTacticRepository::validateData($request);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get());

        $totalReservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get()
        )->count();

        $classicRoom = 0;
        $deluxeRoom = 0;
        $suiteRoom = 0;

        $occupancyRatePerRoomType = [$classicRoom, $deluxeRoom, $suiteRoom];

        foreach ($reservations as $reservation) {

            foreach ($reservation->rooms as $room) {
                if ($room->style == 'classic') {
                    $classicRoom++;
                } elseif ($room->style == 'deluxe') {
                    $deluxeRoom++;
                } elseif ($room->style == 'suite') {
                    $suiteRoom++;
                }
            }
        }

        dd($occupancyRatePerRoomType);

        // TODO - Compter le nombre de chambres par réservation. Ce nombre remplacera $totalReservations

        $occupancyRatePerRoomType[0] = ($classicRoom / $totalReservations) * 100;
        $occupancyRatePerRoomType[1] = ($deluxeRoom / $totalReservations) * 100;
        $occupancyRatePerRoomType[2] = ($suiteRoom / $totalReservations) * 100;

        return response()->json(['occupancy_rate_per_room_type' => $occupancyRatePerRoomType]);

    }


}
