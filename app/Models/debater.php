<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class debater extends Model
{
    protected $fillable = [
        'team_id',
        'position',
        'name',
        'npm',
        'study_program',
        'gender',
        'phone',
        'address'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
