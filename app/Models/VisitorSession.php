<?php namespace App\Models; use Illuminate\Database\Eloquent\Model; class VisitorSession extends Model { protected $guarded=[]; protected function casts(): array { return ['visit_date'=>'date']; } }
