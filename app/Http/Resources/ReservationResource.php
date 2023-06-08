<?php

namespace App\Http\Resources;

use App\Models\Reservation;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Reservation
 */
class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'number_of_people' => $this->number_of_people,
            'checkin' => $this->started_date,
            'checkout' => $this->end_date,
            'has_options' => $this->has_options,
            'price' => $this->price,
            'stay_type' => $this->stay_type,
            'status' => $this->status,
            'rooms' => $this->rooms,
            'options' => $this->options
        ];
    }
}
