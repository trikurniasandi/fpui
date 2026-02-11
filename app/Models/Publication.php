<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\CodeUnit\FunctionUnit;
use function PHPUnit\Framework\returnArgument;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'type',
        'status',
        'user_id',
        'category_id',
        'thumbnail',
        'attachment',
        'show_on_banner',
        'expired_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
