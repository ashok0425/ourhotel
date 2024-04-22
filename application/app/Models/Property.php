<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $casts=[
    'gallery'=>"array",
    'amenities'=>'array'
];

   public function owner(){
        return $this->belongsTo(User::class,'owner_id','id');
    }



    public function city(){
        return $this->belongsTo(City::class);
    }

    public function roomsData(){
        return $this->hasMany(Room::class);
    }


    public function ratings(){
        return $this->hasMany(Testimonial::class);
    }





}
