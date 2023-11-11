<?php

namespace App\Repository;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
