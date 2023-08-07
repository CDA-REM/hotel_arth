<?php

namespace App\Http\Controllers;

use App\Repository\ReservationRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOperationalDashboardData()
    {
        return ReservationRepository::getReservationsByDate(today()->toDateString());
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
