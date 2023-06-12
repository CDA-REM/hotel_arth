<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin KeyCard
 */
class KeyCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
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
