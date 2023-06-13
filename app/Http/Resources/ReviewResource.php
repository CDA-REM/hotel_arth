<?php

namespace App\Http\Resources;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin Review
 */
class ReviewResource extends JsonResource
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
            'body' => $this->body,
            'is_displayed' => $this->is_displayed,
            'rating' => $this->rating,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'user' => UserResource::make($this->user) // Utilise UserResource pour associer les
            // champs de la table user.
        ];
    }
}
