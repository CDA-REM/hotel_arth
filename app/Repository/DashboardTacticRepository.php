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
        try {
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
                throw new ValidationException($validateData);
            }

            return response()->json(['success' => 'Les données envoyées sont valides']);

        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Les données envoyées ne sont pas valides', $e->getMessage()], 400);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue'], 500);
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

    /**
     * Display a listing of reservations taken between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function reservations(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());

            return response()->json($reservations);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the total sales between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function totalSales(Request $request): JsonResponse
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
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the average cart value between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function averageCartValue(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());

            $cartValue = 0;
            $numberOfReservations = $reservations->count();

            foreach ($reservations as $reservation) {
                foreach ($reservation->rooms as $room) {
                    $cartValue += $room->price;
                }
            }

            $averageCartValue = round($cartValue / $numberOfReservations, 2);

            return response()->json(['average_cart' => $averageCartValue]);

        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the average cart value between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function averageCartEvolution(Request $request): JsonResponse
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

            return response()->json(['averageCartEvolution' => $averageCartValues]);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the number of reservations between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function numberOfReservations(Request $request): JsonResponse
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
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the occupancy rate between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function occupancyRate(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $totalReservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])->get())->count();

            $numberOfRooms = Room::all()->count();

            $occupancyRate = ($totalReservations/ ($numberOfRooms * DashboardTacticRepository::calculateDaysDifference($startDate, $endDate))) * 100;

            $occupancyRate = round($occupancyRate, 2);

            return response()->json(['occupancy_rate' => $occupancyRate]);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the occupancy rate per room type between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function occupancyRatePerRoomType(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());

            $classicRoom = 0;
            $deluxeRoom = 0;
            $suiteRoom = 0;
            $occupancyRatePerRoomType = [$classicRoom, $deluxeRoom, $suiteRoom];
            $roomsCounter = 0;

            foreach ($reservations as $reservation) {
                foreach ($reservation->rooms as $room) {
                    switch ($room->style) {
                        case 'classic':
                            $classicRoom++;
                            break;
                        case 'luxury':
                            $deluxeRoom++;
                            break;
                        case 'royal':
                            $suiteRoom++;
                            break;
                    }
                    $roomsCounter++;
                }
            }

            $occupancyRatePerRoomType[0] = round(($classicRoom / $roomsCounter) * 100, 1);
            $occupancyRatePerRoomType[1] = round(($deluxeRoom / $roomsCounter) * 100, 1);
            $occupancyRatePerRoomType[2] = round(($suiteRoom / $roomsCounter) * 100, 1);

            return response()->json(['occupancy_rate_per_room_type' => $occupancyRatePerRoomType]);
        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the occupancy rate per option between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function occupancyRatePerOption(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());
            $totalReservations = $reservations->count();

            $breakfast = 0;
            $lunch = 0;
            $dinner = 0;
            $lunch_and_dinner = 0;
            $laundry = 0;
            $canal_plus = 0;
            $swimming_pool = 0;

            $occupancyRatePerOption = [$breakfast, $lunch, $dinner, $lunch_and_dinner, $laundry, $canal_plus, $swimming_pool];

            foreach ($reservations as $reservation) {
                foreach ($reservation->options as $option) {
                    switch ($option->id) {
                        case 1:
                            $breakfast++;
                            break;
                        case 2:
                            $lunch++;
                            break;
                        case 3:
                            $dinner++;
                            break;
                        case 4:
                            $lunch_and_dinner++;
                            break;
                        case 5:
                            $laundry++;
                            break;
                        case 6:
                            $canal_plus++;
                            break;
                        case 7:
                            $swimming_pool++;
                            break;
                    }
                }
            }

            $occupancyRatePerOption[0] = round(($breakfast / $totalReservations) * 100, 1);
            $occupancyRatePerOption[1] = round(($lunch / $totalReservations) * 100, 1);
            $occupancyRatePerOption[2] = round(($dinner / $totalReservations) * 100, 1);
            $occupancyRatePerOption[3] = round(($lunch_and_dinner / $totalReservations) * 100, 1);
            $occupancyRatePerOption[4] = round(($laundry / $totalReservations) * 100, 1);
            $occupancyRatePerOption[5] = round(($canal_plus / $totalReservations) * 100, 1);
            $occupancyRatePerOption[6] = round(($swimming_pool / $totalReservations) * 100, 1);
            return response()->json(['occupancy_rate_per_option' => $occupancyRatePerOption]);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }

    /**
     * Return the average time between booking and check-in between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function averageTimeBetweenBookingAndCheckin(Request $request): JsonResponse
    {
        try {
            DashboardTacticRepository::validateData($request);

            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $reservations = ReservationResource::collection(Reservation::whereBetween('started_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->get());
            $totalReservations = $reservations->count();

            $totalDays = 0;

            foreach ($reservations as $reservation) {
                $totalDays += DashboardTacticRepository::calculateDaysDifference($reservation->created_at,
                    $reservation->started_date); // Here started_date is used as the check-in date.
                //TODO: Change this to check-in date when this data will be available.
            }

            $averageTimeBetweenBookingAndCheckin = round($totalDays / $totalReservations, 1);

            return response()->json(['average_time_between_booking_and_checkin' => $averageTimeBetweenBookingAndCheckin]);

        } catch (ValidationException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'La valeur saisie est invalide.'], 400);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }


    /**
     * Return the average duration of a checkin process between two dates.
     * @param Request $request
     * @return JsonResponse
     */
    public static function averageDurationOfACheckin(Request $Request): JsonResponse
    {
//        try {
//            //
//
//        } catch (QueryException $e) {
//            Log::error($e->getMessage());
//            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
//        } catch (Exception $e) {
//            Log::error($e->getMessage());
//            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
//        }
    }

    public static function averageDurationOfAStay(Request $request): JsonResponse
    {
        try {
            $reservations = ReservationResource::collection(Reservation::all());
            $totalReservations = $reservations->count();

            $totalDays = 0;

            foreach ($reservations as $reservation) {
                $totalDays += DashboardTacticRepository::calculateDaysDifference($reservation->started_date,
                    $reservation->end_date);
            }

            $averageDurationOfAStay = round($totalDays / $totalReservations, 1);

            return response()->json(['average_duration_of_a_stay' => $averageDurationOfAStay]);
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite au niveau de la base de données.'], 500);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur s\'est produite'], 500);
        }
    }
}
