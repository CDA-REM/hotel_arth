<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationDetails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * @param Reservation $reservation
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("romain.candusso@gmail.com", "Hotel Arth")
                    ->view('mail.reservationDetails')
                    ->with(
                        ['reservation_id' => $this->reservation->id,
                          'checkin' => $this->reservation->started_date]
                    );
    }
}
