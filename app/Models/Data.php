<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'source',
        'email',
        'login',
        'phone_number',
        'phrase',
        'password',
    ];
}
