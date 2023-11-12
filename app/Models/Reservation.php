<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int id
 * @property int user_id
 * @property int number_of_people
 * @property string started_date
 * @property string end_date
 * @property string checkin
 * @property string checkout
 * @property float price
 * @property string stay_type
 * @property string status
 */
class Reservation extends Model
{
    use HasFactory;

    public $timestamps = true;

    public $fillable = ['started_date','end_date', 'checkin', 'checkout', 'user_id', 'number_of_people', 'price', 'stay_type', 'status'];
    /**
     * @return BelongsToMany
     */
    public function rooms() : BelongsToMany
    {
        return $this->belongsToMany(Room::class, 'reservation_rooms');
    }

    /**
     * @return BelongsToMany
     */
    public function options() : BelongsToMany
    {
        return $this->belongsToMany(Option::class, 'reservations_options');
    }

    /**
     * Defines a relationship to user from the reservation table
     * @return BelongsTo
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function keys() : HasMany
    {
        return $this->hasMany(KeyCard::class, 'reservation_id', 'id');
    }
}
