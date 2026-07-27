<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function getCoverImageAttribute(?string $value): ?string
    {
        if (blank($value) || Str::startsWith($value, ['http://', 'https://', 'assets/', 'storage/'])) {
            return $value;
        }

        return 'storage/'.$value;
    }

    public function getCoverUrlAttribute(): ?string
    {
        if (blank($this->cover_image)) {
            return null;
        }

        if (Str::startsWith($this->cover_image, ['http://', 'https://', 'assets/', 'storage/'])) {
            return asset($this->cover_image);
        }

        return asset('storage/'.$this->cover_image);
    }
}
