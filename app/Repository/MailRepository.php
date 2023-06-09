<?php

namespace App\Repository;

use App\Models\Reservation;
use App\Mail\ReservationDetails;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailRepository {
    static function sendMail(Reservation $reservation) : Void
        {    
            Log::info("Sending email to {{$reservation->user->email}}");
            Mail::to($reservation->user->email)->send(new ReservationDetails($reservation));
        }
}