<?php

namespace App\Http\Controllers\API;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Coupon;
use App\Models\Category;
use App\Models\City;
use App\Models\Place;
use App\Models\PlaceType;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    private $response;
    private $city;

    public function __construct(Response $response, City $city)
    {
        $this->response = $response;
        $this->city = $city;
    }


    public function Bannerlist()
    {
        $data = Coupon::query()->select('*','mobile_image as thumb')->get();
        return $this->success_response('Data fetched',$data,200);

    }


    public function list($ishomepage=null)
    {
        // try {
            //code...

        $cities = DB::table('cities')->join('city_translations','city_translations.city_id','cities.id')->orderBy('name','asc')->where('cities.status',1)->select('cities.id','cities.thumb','city_translations.name')->orderBy('city_translations.name','asc')->get();

            // if(isset($ishomepage)&&$ishomepage!=null){
            //    $cities=$cities->whereIn('id',[43,41,42,151,152,62]);
            // }


            // $cities=$cities->get();

        return $this->success_response('Data fetched',$cities,200);

    // } catch (\Throwable $th) {
    //     return $this->error_response('Failed to load data','',400);

    // }
    }

    public function popularCity()
    {
        $cities = City::query()
            ->with('country')
            ->withCount(['places' => function ($query) {
                $query->where('status', Place::STATUS_ACTIVE);
            }])
            ->limit(10)
            ->get();

            return $this->success_response('Data fetched',$cities,200);

    }

    public function detail($id)
    {
        $cat_slug = '';
        /**
         * Get info city
         */
        $city = City::find($id);
        if (!$city) abort(404);

        /**
         * Menu category
         */
        $categories = Category::query()
            ->where('categories.status', Category::STATUS_ACTIVE)
            ->join('places', 'places.category', 'like', DB::raw("CONCAT('%', categories.id, '%')"))
            ->select('categories.id as id', 'categories.name as name', 'categories.priority as priority', 'categories.slug as slug', DB::raw("count(places.category) as place_count"))
            ->groupBy('categories.id')
            ->orderBy('categories.priority')
            ->get();

        /**
         * Loop categories feature and its places
         */
        $category_features = Category::query()
            ->where('is_feature', Category::IS_FEATURE)
            ->where('status', Category::STATUS_ACTIVE)
            ->get(['id', 'name', 'slug', 'feature_title']);
        $features = [];
        foreach ($category_features as $cat) {
            $places = Place::query()
                ->with('place_types')
                ->withCount('reviews')
                ->with('avgReview')
                ->withCount('wishList')
                ->where('city_id', $city->id)
                ->where('category', 'like', '%' . $cat->id . '%')
                ->where('status', Place::STATUS_ACTIVE)
                ->get();
            $features[] = [
                'category_id' => $cat->id,
                'category_name' => $cat->name,
                'category_slug' => $cat->slug,
                'feature_title' => $cat->feature_title,
                'places' => $places,
            ];
        }

        /**
         * Get places of category when user click to menu category
         */
        $places_by_category = [];
        $place_types = PlaceType::query()->get();
        $amenities = Amenities::query()->get();
        if ($cat_slug) {
            $cat = Category::query()
                ->where('slug', $cat_slug)
                ->where('status', Category::STATUS_ACTIVE)
                ->first(['id', 'name', 'slug']);

            $places_by_category['category'] = $cat;
            $places_by_category['places'] = Place::query()
                ->with('place_types')
                ->withCount('reviews')
                ->with('avgReview')
                ->withCount('wishList')
                ->where('city_id', $city->id)
                ->where('category', 'like', '%' . $cat->id . '%')
                ->where('status', Place::STATUS_ACTIVE)
                ->paginate();
        }

        /**
         * Block: Explorer Other Cities
         */
        $other_cities = Cache::remember('other_cities', 60 * 60, function () use ($city) {
            return City::query()
                ->withCount('places')
                ->with('country')
                ->where('status', City::STATUS_ACTIVE)
                ->where('id', '<>', $city->id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        });

        $data= [
            'city' => $city,
            'categories' => $categories,
            'features' => $features,
            'places_by_category' => $places_by_category,
            'other_cities' => $other_cities,
            'cat_slug' => $cat_slug,
            'place_types' => $place_types,
            'amenities' => $amenities,
        ];

        return $this->error_response('Data fetched',$data,200);

    }

}
