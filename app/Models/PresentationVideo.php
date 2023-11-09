<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PresentationVideo extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['title', 'description'];
    public $fillable = ['title', 'video_url', 'description'];
    public $timestamps = true;
}
