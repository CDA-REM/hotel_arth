<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property string key_code
 * @property int room_id
 * @property int reservation_id
 */
class KeyCard extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $fillable = ['key_code', 'room_id', 'reservation_id'];

    /**
     * Defines a relationship to room from the card table
     * @return BelongsTo
     */
    public function room() : BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get the content of the table reservation where reservation_id = reservation.id
     * @return HasOne
     */
    public function reservation(): HasOne
    {
        return $this->hasOne(Reservation::class, 'id', 'reservation_id');
    }
}
