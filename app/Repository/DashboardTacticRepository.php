<?php

namespace App\Repository;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;

class DashboardTacticRepository
{
    /**
     * Return a listing of reservations taken between two dates.
     * @param string $startDate
     * @param string $endDate
     * @return Collection
     */
    public static function getReservationsForPeriod(string $startDate, string $endDate): Collection
    {
        return Reservation::whereBetween('started_date', [$startDate, $endDate])
            ->orWhereBetween('end_date', [$startDate, $endDate])
            ->get();
    }
}
