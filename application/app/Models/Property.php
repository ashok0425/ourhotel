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

   public function user(){
        return $this->belongsTo(User::class);
    }
}
