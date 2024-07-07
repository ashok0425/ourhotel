<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Property extends Model
{
    use HasFactory;

    protected $casts = [
        'gallery' => "array",
        'amenities' => 'array'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }



    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function roomsData()
    {
        return $this->hasMany(Room::class);
    }


    public function ratings()
    {
        return $this->hasMany(Testimonial::class);
    }


    static function getPrice($number_of_adult=1, $number_of_room=1, $room_id,$ishourly=0,$days=1)
    {
        $room = Room::find($room_id);
        $oneprice = $room->onepersonprice;
        $twoprice = $room->twopersonprice ? $room->twopersonprice : $oneprice;
        $diffinprice = $room->threepersonprice ? $room->threepersonprice - $twoprice : $twoprice - $oneprice;
        $threeprice = $room->threepersonprice ? $room->threepersonprice : $twoprice + $diffinprice;

        if ($ishourly==1) {
            $final_adult_price=$room->hourly_price * $number_of_room;
        }else{
        switch ($number_of_adult) {
            case 1:
                $final_adult_price = $number_of_room * $oneprice;
                break;
            case 2:

                if ($number_of_room == 1) {
                    $final_adult_price = $twoprice;
                } else {
                    $final_adult_price = 2 * $oneprice;
                }

                break;
            case 3:

                if ($number_of_room == 1) {
                    $final_adult_price = $threeprice;
                }
                if ($number_of_room == 2) {
                    $final_adult_price = 2 * $twoprice;
                } else {
                    $final_adult_price = $number_of_room * $oneprice;
                }
                break;

            case 4:
                $final_adult_price = $number_of_room * $twoprice;
                break;

            case 5:
                if ($number_of_room == 2) {
                    $final_adult_price = (2 * $twoprice) + $diffinprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }
                break;

            case 6:
                $final_adult_price = $number_of_room * $threeprice;
                break;
            case 7:

                if ($number_of_room == 3) {
                    $final_adult_price = (3 * $twoprice) + $diffinprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 8:

                if ($number_of_room == 3) {
                    $final_adult_price = (3 * $twoprice) + $twoprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }
                break;
            case 9:

                if ($number_of_room == 3) {
                    $final_adult_price = 3 * $threeprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }
                break;
            case 10:

                if ($number_of_room == 4) {
                    $final_adult_price = (2 * $threeprice) + (2 * $twoprice);
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 11:
                $final_adult_price = (2 * $threeprice) + $twoprice;

                if ($number_of_room == 4) {
                    $final_adult_price = (2 * $threeprice) + (2 * $twoprice) + $diffinprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 12:
                if ($number_of_room == 4) {
                    $final_adult_price = 4 * $threeprice;
                } else {
                    $final_adult_price = (3 * $threeprice) +  $twoprice + $diffinprice;
                }
                break;
            case 13:
                if ($number_of_room == 4) {
                    $final_adult_price = (4 * $threeprice) + $diffinprice;
                } else {
                    $final_adult_price = (3 * $threeprice) + (2 * $twoprice);
                }
                break;
            case 14:
                if ($number_of_room == 4) {
                    $final_adult_price = (3 * $threeprice) + (2 * $twoprice) + $diffinprice;
                } else {
                    $final_adult_price = (3 * $threeprice) + (3 * $twoprice);
                }
                break;
            case 15:
                $final_adult_price = 5 * $threeprice;
                break;

            default:
                $final_adult_price = $number_of_room * $oneprice;

                break;
        }
    }

        return $final_adult_price*$days;
    }


    static function searchSuggestion($keyword)
    {
        $data = [];
        $cities = City::where('name', 'LIKE', "%$keyword%")
            ->select(
                'cities.id',
                'cities.name',
                'cities.slug',
                DB::raw('(SELECT COUNT(*) FROM properties WHERE properties.city_id = cities.id) as count'),
                DB::raw('"city" as type'),
                DB::raw('" " as address')
            )->get()
            ->toArray();


        $locations = Location::where('name', 'LIKE', "%$keyword%")
            ->select(
                'locations.id',
                'locations.name',
                'locations.slug',
                'locations.latitude',
                'locations.longitude',
                DB::raw('(
                    SELECT COUNT(*)
                    FROM properties
                    WHERE ST_Distance_Sphere(
                        point(properties.longitude, properties.latitude),
                        point(locations.longitude, locations.latitude)
                    ) <= 2000
                ) as count'),
                DB::raw('"area" as type'),
                DB::raw('" " as address')

            )
            ->get()
            ->toArray();

        $properties = Property::where('name', 'LIKE', "%$keyword%")->orWhere('slug', 'LIKE', "%$keyword%")->select(
            'name',
            'id',
            'slug',
            'address',
            DB::raw('"hotel" as type'),
            DB::raw('"0" as count')
        )->get()->toArray();

        $newArray = array_merge($data, $cities, $locations, $properties);
        return $newArray;
    }


    public static function propertyFilter($cityId = null, $areaId = null, $minprice = null, $maxprice = null, $star = null, $place_type = null)
{
    $places = Property::select('properties.*')
        ->with('ratings')
        ->with('roomsData')
        ->whereHas('roomsData', function ($query) use ($minprice,$maxprice) {
            $query->whereNotNull('onepersonprice')
            ->when($minprice && $maxprice, function ($query) use ($minprice, $maxprice) {
                $query->whereBetween('onepersonprice', [$minprice, $maxprice]);
            });
        })
        ->selectSub(function($query) {
            $query->from('rooms')
                ->select('onepersonprice')
                ->whereColumn('properties.id', 'rooms.property_id')
                ->limit(1);
        }, 'onepersonprice')
        ->selectSub(function ($query) {
            $query->from('testimonials')
                ->selectRaw('AVG(rating)')
                ->whereColumn('properties.id', 'testimonials.property_id');
        }, 'avg_rating')
        ->when($cityId, function ($query) use ($cityId) {
            $query->where('city_id', $cityId);
        })
        ->when($areaId, function ($query) use ($areaId) {
            $location = Location::find($areaId);
            if ($location) {
                $query->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$location->latitude, $location->longitude, $location->latitude])
                      ->having('distance', '<=', 2);
            }
        })
        ->when($star, function ($query) use ($star) {
            // Use HAVING clause instead of WHERE for avg_rating
            $query->havingRaw('avg_rating IN (?)', $star);
        })
        ->when($place_type, function ($query) use ($place_type) {
            $query->whereIn('property_type_id', $place_type);
        })
        ->paginate(125);

    return $places;
}



}
