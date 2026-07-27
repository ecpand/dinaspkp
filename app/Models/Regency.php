<?php namespace App\Models; use Illuminate\Database\Eloquent\Model; class Regency extends Model { protected $guarded=[]; public function villages(){return $this->hasMany(Village::class);} }
