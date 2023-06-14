<?php

namespace App\Http\Resources;

use App\Models\KeyCard;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin KeyCard
 */
class KeyCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request) :array
    {
        return [
            'id' => $this->id,
            'key_code' => $this->key_code,
            'room_id' => $this->room_id,
            'reservation' => ReservationResource::make($this->reservation), //Use ReservationResource to associate the fields of the reservation table.
        ];
    }
}
