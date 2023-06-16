<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin KeyCard
 * @property mixed id
 * @property mixed key_code
 * @property mixed room_id
 */

class KeyCardLightResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * Return fields id, key_code, room_id
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
        ];
    }
}
