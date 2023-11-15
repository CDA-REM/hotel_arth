<?php

namespace App\Services;

use App\Models\Room;
use App\Repository\DashboardTacticRepository;
use Exception;
use Illuminate\Support\Carbon;

class DashboardTacticService
{
    protected DashboardTacticRepository $dashboardTacticRepository;

    /**
     * Constructor for the class.
     *
     * @param DashboardTacticRepository $dashboardTacticRepository The repository for accessing the DashboardTactic data.
     */
    public function __construct(DashboardTacticRepository $dashboardTacticRepository)
    {
        $this->dashboardTacticRepository = $dashboardTacticRepository;
    }

    /**
     * Calculates the difference in days between two given dates.
     *
     * @param string $startDate The start date.
     * @param string $endDate The end date.
     * @return bool|int The difference in days.
     * @throws Exception
     */
    public static function calculateDaysDifference(string $startDate, string $endDate): bool|int
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = $start->diff($end);
        return $interval->days;
    }

    /**
     * Calculate the total sales for a given period.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @return float The total sales for the given period.
     */
    public function calculateTotalSales(string $startDate, string $endDate): float
    {
        $reservations = $this->dashboardTacticRepository->getReservationsForPeriod($startDate, $endDate);
        return $reservations->sum('price');
    }

    /**
     * Calculates the average cart value for a given period.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @return float|int The average cart value.
     */
    public function calculateAverageCartValue(string $startDate, string $endDate): float|int
    {
        $reservations = $this->dashboardTacticRepository->getReservationsForPeriod($startDate, $endDate);

        $cartValue = 0;
        $numberOfReservations = $reservations->count();

        foreach ($reservations as $reservation) {
            foreach ($reservation->rooms as $room) {
                $cartValue += $room->price;
            }
        }

        return $numberOfReservations > 0 ? round($cartValue / $numberOfReservations, 2) : 0;
    }

    /**
     * Calculate the average cart evolution for a given period.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @return array The average cart evolution as an array with 'date_list' and 'value_list'.
     */
    public function calculateAverageCartEvolution(string $startDate, string $endDate): array
    {
        $reservations = $this->dashboardTacticRepository->getReservationsForPeriod($startDate, $endDate);

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

        uksort($cartValues, function ($a, $b) {
            return strtotime($a) - strtotime($b);
        });

        $dateList = [];
        $valueList = [];

        foreach ($cartValues as $date => $values) {
            $averageValue = $values['value'] / $values['count'];
            $averageValueRounded = round($averageValue, 2);
            $dateList[] = $date;
            $valueList[] = $averageValueRounded;
        }

        return [
            'date_list' => $dateList,
            'value_list' => $valueList
        ];
    }

    public function calculateNumberOfReservations(string $startDate, string $endDate): int
    {
        $reservations = DashboardTacticRepository::getReservationsForPeriod($startDate, $endDate);

        return $reservations->count();
    }

    /**
     * Calculates the occupancy rate for a given period.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @return int|float The occupancy rate as a percentage.
     * @throws Exception
     */
    public function calculateOccupancyRate(string $startDate, string $endDate): int |float
    {
        $reservations = DashboardTacticRepository::getReservationsForPeriod($startDate, $endDate);

        $totalReservations = $reservations->count();
        $numberOfRooms = Room::all()->count();

        $occupancyRate = ($totalReservations / ($numberOfRooms * DashboardTacticService::calculateDaysDifference($startDate, $endDate))) * 100;

        return round($occupancyRate, 2);
    }

    /**
     * Calculates the occupancy rate per room type for a given period.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @return array An array of occupancy rates per room type.
     */
    public function calculateOccupancyRatePerRoomType(string $startDate, string $endDate): array
    {
        $reservations = DashboardTacticRepository::getReservationsForPeriod($startDate, $endDate);

        $numClassicRooms = 0;
        $numDeluxeRooms = 0;
        $numSuiteRooms = 0;
        $roomsCounter = 0;

        foreach ($reservations as $reservation) {
            foreach ($reservation->rooms as $room) {
                switch ($room->style) {
                    case 'classic':
                        $numClassicRooms++;
                        break;
                    case 'deluxe':
                        $numDeluxeRooms++;
                        break;
                    case 'suite':
                        $numSuiteRooms++;
                        break;
                }
                $roomsCounter++;
            }
        }

        // Avoid division by zero and return an array of numbers of rooms by room type
        if ($roomsCounter > 0) {
            return [
                round(($numClassicRooms / $roomsCounter) * 100, 1),
                round(($numDeluxeRooms / $roomsCounter) * 100, 1),
                round(($numSuiteRooms / $roomsCounter) * 100, 1)
            ];
        }

        return [0, 0, 0]; // Return zero occupancy rate if no rooms
    }

    /**
     * Calculate the occupancy rate per option for a given period.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @return array The occupancy rate per option.
     */
    public function calculateOccupancyRatePerOption(string $startDate, string $endDate): array
    {
        // Get reservations for the period
        $reservations = DashboardTacticRepository::getReservationsForPeriod($startDate, $endDate);

        // Count the total number of reservations
        $totalReservations = $reservations->count();

        // Initialize counters for each option
        $breakfast = 0;
        $lunch = 0;
        $dinner = 0;
        $lunch_and_dinner = 0;
        $laundry = 0;
        $canal_plus = 0;
        $swimming_pool = 0;

        // Iterate over each reservation
        foreach ($reservations as $reservation) {
            // Iterate over each option in the reservation
            foreach ($reservation->options as $option) {
                // Increment the respective option counter based on the option ID
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
                }
            }
        }

        // Calculate and return the occupancy rate per option
        if ($totalReservations > 0) {
            return [
                round(($breakfast / $totalReservations) * 100, 1),
                round(($lunch / $totalReservations) * 100, 1),
                round(($dinner / $totalReservations) * 100, 1),
                round(($lunch_and_dinner / $totalReservations) * 100, 1),
                round(($laundry / $totalReservations) * 100, 1),
                round(($canal_plus / $totalReservations) * 100, 1),
                round(($swimming_pool / $totalReservations) * 100, 1)
            ];
        }

        // If there are no reservations, return zero values for the occupancy rate
        return [0, 0, 0, 0, 0, 0, 0];
    }

    /**
     * Calculate the average time between booking and check-in for a given period.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @return int The average time in days.
     * @throws Exception
     */
    public function calculateAverageTimeBetweenBookingAndCheckin(string $startDate, string $endDate): int
    {
        $reservations = DashboardTacticRepository::getReservationsForPeriod($startDate, $endDate);

        $totalReservations = $reservations->count();

        $totalDays = 0;

        foreach ($reservations as $reservation) {
            $totalDays += DashboardTacticService::calculateDaysDifference($reservation->created_at, $reservation->started_date); // Here started_date is used as the check-in date.
            //TODO: Change this to check-in date when real data will be available.
        }

        if ($totalReservations > 0) {
            return round($totalDays / $totalReservations, 1);
        }

        return 0;
    }

    /**
     * Calculates the average duration of a stay based on the given start and end dates.
     *
     * @param string $startDate The start date of the period.
     * @param string $endDate The end date of the period.
     * @throws Exception
     * @return int The average duration of a stay in days.
     */
    public function calculateAverageDurationOfAStay(string $startDate, string $endDate): int
    {
        $reservations = DashboardTacticRepository::getReservationsForPeriod($startDate, $endDate);

        $totalReservations = $reservations->count();

        $totalDays = 0;

        foreach ($reservations as $reservation) {
            $totalDays += DashboardTacticService::calculateDaysDifference($reservation->started_date, $reservation->end_date);
        }

        if ($totalReservations > 0) {
            return round($totalDays / $totalReservations, 1);
        }

        return 0;
    }
}
