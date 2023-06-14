<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Review extends Model
{
    use HasFactory;

    public $timestamps = ["created_at"]; // We only want to use created_at column
    const UPDATED_AT = null; // updated_at column will be set to null by default

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [
        'user_id',
        'rating',
        'title',
        'body',
        'is_displayed',
    ];


    /**
     * Get the content of the table users where user_id = user.id
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
