<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\PlaceType;
use App\Models\Booking;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ReferelMoney;
class PlaceController extends Controller
{

    public function detail(Request $request,$slug)
    {

        $place =Property::where('slug',$request->slug)->firstOrFail();

          $city = $place->city;
        $amenities = Amenity::whereIn('id', $place->amenities ? $place->amenities : [])
            ->get(['id', 'name', 'thumbnail']);
        $categories = Category::query()
            ->whereIn('id', $place->category ? $place->category : [])
            ->get(['id', 'name', 'slug']);

        $place_types = PropertyType::query()
            ->whereIn('id', $place->place_type ? $place->place_type : [])
            ->get(['id', 'name']);


        $similar_places = Property::query()
            ->withCount('ratings')
            ->whereHas('roomsData')
            ->where('city_id', $city->id)
            ->where('id', '!=', $place->id)->limit(4)->get();


        return view("frontend.place.place_detail_01", [
            'place'            => $place,
            'places'            => $place,
            'city'             => $city,
            'amenities'        => $amenities,
            'categories'       => $categories,
            'place_types'      => $place_types,
            'similar_places'   => $similar_places,
        ]);

    }


}
