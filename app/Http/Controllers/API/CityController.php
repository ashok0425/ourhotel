<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use App\Models\City;
use App\Models\Place;
use App\Models\PlaceType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{



    public function Bannerlist()
    {
        $data = coupons();
        return $this->success_response('Data fetched',$data,200);

    }


    public function list($ishomepage=null)
    {

        $cities = City::orderBy('name','asc')->select('name','id','thumbnail as thumb')->where('status',1)
        ->when($ishomepage,function($query){
            $query->whereIn('id',[43,41,42,151,152,62]);
        })
        ->get();



        return $this->success_response('Data fetched',$cities,200);
    }

    public function popularCity()
    {
          $cities= popular_cities();
            return $this->success_response('Data fetched',$cities,200);

    }


}
