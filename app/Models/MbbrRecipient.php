<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MbbrRecipient extends Model
{
    protected $guarded = [];
    protected function casts(): array { return ['progress' => 'decimal:2','material_cost'=>'decimal:2','labor_cost'=>'decimal:2','material_progress'=>'decimal:2','labor_progress'=>'decimal:2','material_remaining'=>'decimal:2','labor_remaining'=>'decimal:2']; }
    public function program() { return $this->belongsTo(MbbrProgram::class, 'mbbr_program_id'); }
    public function regency() { return $this->belongsTo(Regency::class); }
    public function village() { return $this->belongsTo(Village::class); }
}
