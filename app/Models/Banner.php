<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'thumbnail',
        'expired_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


}
