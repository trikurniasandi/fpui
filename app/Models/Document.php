<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'slug',
        'description',
        'file',
        'external_url',
        'published_at',
        'status',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * URL unduhan: file lokal diutamakan, lalu tautan eksternal.
     */
    public function downloadUrl(): ?string
    {
        if ($this->file) {
            return asset('storage/' . $this->file);
        }

        return $this->external_url ?: null;
    }
}
