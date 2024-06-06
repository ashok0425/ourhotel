<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\City;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
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


    public function pageAddNew()
    {


        $countries  = State::all();
        $cities     = City::all();

        $place_types = PropertyType::query()
            ->get();

            $categories = Category::query()
            ->get();

        return view('frontend.place.place_addnew', [
            'countries'   => $countries,
            'cities'      => $cities,
            'place_types' => $place_types,
            'categories'=>$categories
        ]);
    }


    public function create(Request $request)
    {
        dd($request->all());
        $request->validate(
            ['partner_name'=>'required',
            'partner_name'=>'required',
            'address'=>'required',
            'email'=>'required|unique:users,email',
            'phone_number'=>'required|unique:users,phone_number'
            ]
        );



    }


}
