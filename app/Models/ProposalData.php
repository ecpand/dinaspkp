<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProposalData extends Model
{
    use SoftDeletes;

    protected $table = 'proposal_data';

    protected $guarded = [];

    protected $casts = [
        'source_number' => 'integer',
        'proposal_year' => 'integer',
        'beneficiary_count' => 'integer',
        'estimated_budget' => 'decimal:2',
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
