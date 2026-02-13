<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OrganizationProfile extends Model
{
    protected $table = 'organization_profiles';

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'about',
        'vision',
        'mission',
        'email',
        'phone',
        'address',
        'province',
        'city',
        'postal_code',
        'latitude',
        'longitude',
        'instagram',
        'facebook',
        'youtube',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = static::generateUniqueSlug($model->name);
            }
        });
    }

    protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::where('slug', 'LIKE', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
