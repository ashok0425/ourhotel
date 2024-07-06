<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    public function locations(){
        return $this->hasMany(Location::class);
    }

    public function property(){
        return $this->hasMany(Property::class);
    }

    public function state(){
        return $this->belongsTo(State::class);
    }
}
