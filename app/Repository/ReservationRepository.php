<?php

namespace App\Repository;

use App\Http\Resources\DashboardOperationalTableResource;
use App\Http\Resources\ReservationResource;
use App\Models\Option;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;


class ReservationRepository
{
    static function calculateReservationPrice(array $validated, array $rooms) : float|int
    {
        // Calculating the price of the options if any
        if (isset($validated["formOptions"])) {
            $option_price = ReservationRepository::calculateOptionPrice($validated, count($rooms));
        }

        // Creating the final array
        $rooms_prices = [ ...Room::whereIn("id", $rooms)->select('price')->pluck('price') ];
        $prices = (isset($option_price)) ? [$option_price, ...$rooms_prices] : $rooms_prices;

        // Returning the sum
        return array_reduce($prices, function ($curr, $acc) {
            return $curr + $acc;
        });
    }

    private static function calculateOptionPrice(array $validated, int $numberOfRooms) : float|int
    {
        $started_date = $validated["started_date"];
        $end_date = $validated["end_date"];
        $people = $validated["numberOfPeople"];
        // Carbon is a class used to work with dates
        $number_of_days = Carbon::parse($started_date)->diffInDays(Carbon::parse($end_date));

        $option_price = 0;
        $options = $validated["formOptions"];
        $options = Option::whereIn("id", $options)->select("id", "option_price")->get();

        foreach($options as $option) {
            if (in_array($option->id, array(1,2,3,4,5))) {
                $option_price += $option->option_price * $people * $number_of_days;
            } elseif ($option->id === 6) {
                $option_price += 10 * ceil($number_of_days/7) * $numberOfRooms;
            } else {
                $option_price += 25;
            }
        }

        return $option_price;
    }

    /**
     * @param string $date
     * @return Collection
     */
    static function getAvailableRooms($started_date, $end_date) {
        // Get the id of every reservation between two dates
        $reservationsIdArray = Reservation::whereBetween("started_date", [$started_date, $end_date])
            ->orWhereBetween("end_date", [$started_date, $end_date])
            ->pluck("id");

        // Retrieve Reservations in a Collection
        $reservations = Reservation::whereIn("id", $reservationsIdArray)->get();

        // Iterate over the collection of Reservation models to retrieve the rooms booked
        $booked = [];
        forEach ($reservations as $reservation) {
            $booked = [ ...$reservation->rooms->pluck("id") ];
        };
        // Return the free rooms
        return Room::all()->whereNotIn("id", array_unique($booked));

    }

    /**
     * @param string $date
     * @return array
     */
    public static function getFormattedReservationsByDate(string $date) {
        $collection = ReservationRepository::getReservationsByDate($date);

        return ReservationRepository::formatReservationsForDashboardTable($collection, $date);
    }

    /**
     * @param string $date
     * @return Collection
     */
    static function getReservationsByDate(string $date) {
        return Reservation::all()
            ->where('started_date', '<=', $date)
            ->where('end_date', '>=', $date)
            ->whereIn("status", ["in progress", "validated"]);
    }

    /**
     * @param Collection $collection
     * @param string $date
     * @return array
     */
    static function formatReservationsForDashboardTable(Collection $collection, string $date) {

        $formatedColl = [];
        $occupiedRooms = [];

        foreach($collection as $reservation) {

            // n² complexity for the win ! The heavier the better.
            foreach($reservation->rooms as $room) {

                // Formatting like a goddamn monkey instead of using Resources.
                // One room number per object.
                $formatted_reservation = [
                    'tags' => 'occupée',
                    'nom' => $reservation->user->firstname . ' ' . $reservation->user->lastname,
                    'arrivee' => $reservation->started_date,
                    'depart' => $reservation->end_date,
                    'chambre' => $room->room_number,
                    'nombreCle' => $reservation->keys->count()
                ];

                array_push($formatedColl, $formatted_reservation);

                if ($reservation->end_date != $date && $reservation->status != "terminated") {
                    array_push($occupiedRooms, $room->room_number);
                }
            }
        }

        // Complete the array with available rooms for display in the dashboard
        $available = Room::all()->whereNotIn("room_number", array_unique($occupiedRooms));

        foreach($available as $room) {
            array_push($formatedColl, ['tags' => 'disponible', 'chambre' => $room->room_number]);
        };

        return $formatedColl;
    }

    public static function getReservationsTotalNumberOfPeople($date) {
        // Get an array of number_of_people per reservation
        $people = ReservationRepository::getReservationsByDate($date)->pluck('number_of_people')->toArray();

        return array_sum($people);
    }

    public static function getReservationsMenusByDate($date) {
        $collection = ReservationRepository::getReservationsByDate($date);
        // return ReservationResource::collection($collection);
        $breakfast = 0;
        $lunch = 0;
        $diner = 0;

        foreach($collection as $reservation) {
            // Log::info($reservation);
            foreach($reservation->options as $option) {

                if ($option->id === 1
                && $reservation->started_date != $date) {
                    $breakfast += $reservation->number_of_people;
                }

                if (in_array($option->id, [2, 4])
                    && $reservation->end_date != $date) {
                    $lunch += $reservation->number_of_people;
                }

                if (in_array($option->id, [3, 4])
                    && $reservation->end_date != $date) {
                    $diner += $reservation->number_of_people;
                }
            }
        }

        $menus = [
            'breakfast' => $breakfast,
            'lunch' => $lunch,
            'diner' => $diner
        ];

        return $menus;
    }
}
