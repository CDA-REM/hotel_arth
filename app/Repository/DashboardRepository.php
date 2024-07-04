<?php

namespace App\Repository;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Carbon\Carbon;
use Exception;
use function PHPUnit\Framework\throwException;

class DashboardRepository {
    // Get period
    public static function getPeriod($selectedPeriod) {
        $date = '01/'. $selectedPeriod . '00:00:00';
        $newDate = Carbon::createFromFormat('d/m/Y H:i:s', $date);
        $startDate = $newDate->startOfMonth()->format('Y-m-d H:i:s'); // 2000-02-01 00:00:00
        $endDate = $newDate->endOfMonth()->format('Y-m-d H:i:s'); // 2000-02-29 23:59:59

        return [$startDate, $endDate];
    }

    // Sales calculation
    public static function getAllSalesInSelectedPeriod($periodArray) {

        return Reservation::All()
            ->where('created_at', '>=', $periodArray[0])
            ->where('created_at', '<=', $periodArray[1])
            ->pluck('price');
    }

    public static function sumOfSales($collectionOfSales) {
        // Convert a collection to array
        $arrayOfSales = $collectionOfSales->toArray();

        return array_sum($arrayOfSales);
    }


    // Number of reservations
    public static function getNumberOfReservations($periodArray) {
        $reservationsOnPeriod = Reservation::All()
            ->where('created_at', '>=', $periodArray[0])
            ->where('created_at', '<=', $periodArray[1])
            ->pluck('id');

        // Convert a collection to array
        $arrayOfReservations = $reservationsOnPeriod->toArray();
        return count($arrayOfReservations);

    }

    // Time average between reservation date and check-in

    public static function averageTimeReservationCheckin($periodArray) {

//        $test = $reservationsOnPeriod->toArray();

            $reservationsOnPeriod = Reservation::All()
                ->where('created_at', '>=', $periodArray[0])
                ->where('created_at', '<=', $periodArray[1])
                ->pluck('created_at');

        $filtered = $reservationsOnPeriod.date_create_from_format('d/m/Y  ',$periodArray[0]);

    }

//    public static function fillingRate($periodArray) {
//        $daysInTheMmonth = date_diff($periodArray[1], $periodArray[0]);
//        dd($daysInTheMmonth);
//    }

//}

    //
}

