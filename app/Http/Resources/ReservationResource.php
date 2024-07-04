<?php

namespace App\Http\Resources;

use App\Models\KeyCard;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Reservation
 */
class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_civility' => $this->user->civility,
            'user_name' => $this->user->firstname .' '. $this->user->name,
            'number_of_people' => $this->number_of_people,
            'started_date' => $this->started_date,
            'end_date' => $this->end_date,
            'checkin' => $this->checkin,
            'checkout' => $this->checkout,
            'price' => $this->price,
            'stay_type' => $this->stay_type,
            'status' => $this->status,
            'rooms' => RoomResource::collection($this->rooms), //
            'options' => OptionResource::collection($this->options),
            'key_cards' => KeyCardResource::collection($this->key_cards)
        ];
    }
}
