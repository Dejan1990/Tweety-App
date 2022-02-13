<?php

namespace App\Models;

use App\Followable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Followable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarAttribute($value)
    {
        //return asset($value);
        return asset('storage/' . $value);
    }

    // Next episode...
    //    public function setPasswordAttribute($value)
    //    {
    //    }

    public function timeline()
    {
        $friends = $this->follows()->pluck('id'); // $this->follows()->pluck('id')-> this way we get only id-s, not full collection of users -> $this->follows->pluck('id')

        return Tweet::whereIn('user_id', $friends)
            ->orWhere('user_id', $this->id)
            ->latest()->get();
    }

    public function tweets()
    {
        return $this->hasMany(Tweet::class)->latest();
    }

    public function path($append = '')
    {
        $path = route('profile', $this->username);

        return $append ? "{$path}/{$append}" : $path;
    }
}
