<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
     */
    public function getTacticalDashboardData()
    {
        //
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStrategicalDashboardData()
    {
        //
    }
}
