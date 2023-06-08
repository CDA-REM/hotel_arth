<?php

namespace App\Repository;

use App\Models\Option;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
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
        $checkin = $validated["started_date"];
        $checkout = $validated["end_date"];
        $people = $validated["numberOfPeople"];
        // Carbon is a class used to work with dates
        $number_of_days = Carbon::parse($checkin)->diffInDays(Carbon::parse($checkout));

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

    static function getAvailableRooms($checkin, $checkout) {
        // Get the id of every reservation between two dates
        $reservationsIdArray = Reservation::whereBetween("started_date", [$checkin, $checkout])
            ->orWhereBetween("end_date", [$checkin, $checkout])
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
}


