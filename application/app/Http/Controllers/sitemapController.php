<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Place;
use App\Models\Post;
use Illuminate\Http\Request;

// use Illuminate\Http\Request;

class sitemapController extends Controller
{
    public function index(Request $request)
    {

        $city = City::query()
            ->with('country')
            ->withCount(['places' => function ($query) {
                $query->where('status', Place::STATUS_ACTIVE);
            }])
            ->where('status', Country::STATUS_ACTIVE);
            $cities['datas'] = $city->get();


        return response()->view('frontend.sitemapIndex', $cities)->header('Content-Type', 'text/xml');
    }

    public function sitemapCity(Request $request)
    {

        $city = City::query()
            ->with('country')
            ->withCount(['places' => function ($query) {
                $query->where('status', Place::STATUS_ACTIVE);
            }])
            ->where('status', Country::STATUS_ACTIVE);

            $cities['datas'] = $city->get();


        return response()->view('frontend.sitemapCity', $cities)->header('Content-Type', 'text/xml');
    }
    private $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }

    public function sitemapHotel(Request $request, $slug, $cat_slug = null)
    {
        $city = $this->city->getBySlug($slug);
        if (!$city) abort(404);

      $hotels = Place::query()
                ->where('city_id', $city->id)
                ->where('status', Place::STATUS_ACTIVE);



         $places['datas'] = $hotels->get();


//        return $places_by_category;
        return response()->view('frontend.sitemapHotel', $places)->header('Content-Type', 'text/xml');

            }
    public function sitemapBlog()
    {


        $posts = Post::query()
            ->with('user')
            ->where('type', Post::TYPE_BLOG)
            ->where('status', Post::STATUS_ACTIVE);


        $postlist['datas'] = $posts->get();

        // $post_total = Post::query()
        //     ->where('type', Post::TYPE_BLOG)
        //     ->where('status', Post::STATUS_ACTIVE)
        //     ->count();



        return response()->view('frontend.sitemapBlog', $postlist)->header('Content-Type', 'text/xml');

    }
}
