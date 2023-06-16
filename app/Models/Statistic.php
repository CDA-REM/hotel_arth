<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property int key_card_id
 * @property string traceability
 */
class Statistic extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public $fillable = ['key_card_id', 'traceability'];

    // Automatically cast the traceability field to an array
//    protected $casts = [
//        'traceability' => 'array'
//    ];

    /**
     * Defines a relationship to card from the statistic table
     * @return BelongsTo
     */
    public function keycard() : BelongsTo
    {
        return $this->belongsTo(KeyCard::class);
    }
}
