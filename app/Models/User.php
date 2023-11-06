<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends \TCG\Voyager\Models\User
{
    use HasApiTokens, HasFactory, Notifiable;

    //    To stop Laravel from creating updated_at and created_at fields while populating the db with a seeder
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'avatar_url',
        'password',
        'civility',
        'personal_address',
        'enterprise_name',
        'user_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
//        'remember_token',
    ];

//    public function role()
//    {
//        return $this->hasOne(Role::class, 'name', 'role');
//    }
//
//    public static function create(array $attributes = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
//    {
//        $attributes['role'] = 'user'; // Rôle par défaut
//        return static::query()->create($attributes);
//    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    /* TODO - Enable ?
     * protected $casts = [
        'email_verified_at' => 'datetime',
    ];*/

}
