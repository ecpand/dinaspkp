<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StructuralOfficial extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'date_of_birth' => 'date', 'position_started_at' => 'date'];
    }
}
