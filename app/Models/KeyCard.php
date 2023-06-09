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
class KeyCard extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public $fillable = ['key_code', 'room_id'];

    /**
     * Defines a relationship to room from the card table
     * @return BelongsTo
     */
    public function room() : BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
