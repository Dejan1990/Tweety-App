<?php

namespace App\Models;

use App\Likable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tweet extends Model
{
    use HasFactory, Likable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
