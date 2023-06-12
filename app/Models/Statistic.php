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

    public $timestamps = true;

    public $fillable = ['card_id', 'traceability'];

    /**
     * Defines a relationship to card from the statistic table
     * @return BelongsTo
     */
    public function card() : BelongsTo
    {
        return $this->belongsTo(Card::class);
    }
}
