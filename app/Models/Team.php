<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'reason', 'payment_method', 'payment_validated'];

    public function debaters()
    {
        return $this->hasMany(Debater::class);
    }
}
