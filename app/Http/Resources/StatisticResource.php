<?php

namespace App\Http\Resources;

use App\Models\Statistic;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Statistic
 */
class StatisticResource extends JsonResource
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
            'key_card_id' => $this->key_card_id,
            'traceability' => $this->traceability,
        ];
    }
}
