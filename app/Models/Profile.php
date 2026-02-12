<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'description',
        'about',
        'vision',
        'mission',
        'email',
        'phone',
        'address',
        'instagram',
        'facebook',
    ];
}
