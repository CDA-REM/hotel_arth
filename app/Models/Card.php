<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int id
 * @property string key
 */
class Card extends Model
{
    use HasFactory;

    public $timestamps = true;

    public $fillable = ['key', 'room_id'];

    public function rooms() : BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'card_rooms');
    }

    /**
     * Defines a relationship to room from the card table
     * @return BelongsTo
     */
    public function room() : BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

}
