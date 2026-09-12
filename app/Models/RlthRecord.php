<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RlthRecord extends Model
{
    protected $guarded = [];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'building_area' => 'decimal:2',
        'submitted_at' => 'datetime',
        'consented_at' => 'datetime',
    ];

    public function photoUrl(string $column): ?string
    {
        return $this->{$column} ? asset('storage/'.$this->{$column}) : null;
    }
}
