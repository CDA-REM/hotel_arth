<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Repository\DashboardRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getOperationalDashboardData()
    {
        //
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
     * @return \Illuminate\Http\JsonResponse $request
     */
    public function getStrategicalDashboardData(Request $request): \Illuminate\Http\JsonResponse
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
