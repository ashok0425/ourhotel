<?php

use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('states')->delete();
        DB::table('cities')->delete();
        DB::table('amenities')->delete();
        DB::table('locations')->delete();
        DB::table('categories')->delete();
        DB::table('property_types')->delete();
        DB::table('faqs')->delete();


        //states
        $states=DB::connection("mysql_2")->table('countries')->get();
        foreach ($states as $key => $state) {
           DB::table('states')->insert([
            'id'=>$state->id,
            'name'=>$state->name,
            'slug'=>$state->slug,
            'status'=>$state->status,
            'meta_keyword'=>$state->seo_title,
            'meta_title'=>$state->seo_title,
            'meta_description'=>$state->seo_description,
            'mobile_meta_keyword'=>$state->seo_title,
            'mobile_meta_title'=>$state->seo_title,
            'mobile_meta_description'=>$state->seo_description,
           ]);
        }



        //cities
        $cities=DB::connection("mysql_2")->table('cities')->get();
        foreach ($cities as $key => $city) {
            $name=DB::connection("mysql_2")->table('city_translations')->where('city_id',$city->id)->first();
           DB::table('cities')->insert([
            'id'=>$city->id,
            'name'=>$name->name,
            'state_id'=>$city->country_id,
            'slug'=>$city->slug,
            'status'=>$city->status,
            'meta_keyword'=>$city->seo_keywords,
            'meta_title'=>$city->seo_title,
            'meta_description'=>$city->seo_description,
            'mobile_meta_keyword'=>$city->seo_keywords,
            'mobile_meta_title'=>$city->seo_title,
            'mobile_meta_description'=>$city->seo_description,
           ]);
        }


        //animities
        $amenities=DB::connection("mysql_2")->table('amenities')->get();
        foreach ($amenities as $key => $amenity) {
            $name=DB::connection("mysql_2")->table('amenities_translations')->where('amenities_id',$amenity->id)->first();
           DB::table('amenities')->insert([
            'name'=>$name->name,
            'status'=>1,
            'thumbnail'=>$amenity->icon,
           ]);
        }


        //city locations

        $city_locations=DB::connection("mysql_2")->table('city_location')->get();
        foreach ($city_locations as $key => $city_location) {
           DB::table('locations')->insert([
            'name'=>$city_location->location_name,
            'status'=>1,
            'city_id'=>$city_location->city_id,
            'slug'=>Str::slug($city_location->location_name),
            'meta_keyword'=>$city_location->keyword,
            'meta_title'=>$city_location->title,
            'meta_description'=>$city_location->description,
            'mobile_meta_keyword'=>$city_location->keyword,
            'mobile_meta_title'=>$city_location->title,
            'mobile_meta_description'=>$city_location->description,
            'latitude'=>$city_location->lat_n,
            'longitude'=>$city_location->long_e,
           ]);
        }

          //categories
          $categories=DB::connection("mysql_2")->table('categories')->get();
          foreach ($categories as $key => $category) {
              $name=DB::connection("mysql_2")->table('category_translations')->where('category_id',$category->id)->first();
             DB::table('categories')->insert([
              'name'=>$name->name,
              'status'=>1,
              'slug'=>Str::slug($name->name)
             ]);
          }


        //property types
        $types=DB::connection("mysql_2")->table('place_types')->get();
        foreach ($types as $key => $type) {
            $name=DB::connection("mysql_2")->table('place_type_translations')->where('place_type_id',$type->id)->first();
           DB::table('property_types')->insert([
            'name'=>$name->name,
            'category_id'=>$type->category_id,
            'status'=>1,
            'slug'=>Str::slug($name->name)
           ]);
        }


        // Faqs
        $faqs=DB::connection("mysql_2")->table('faq')->get();
        foreach ($faqs as $key => $faq) {
           DB::table('locations')->insert([
            'question'=>$faq->question,
            'answer'=>$faq->answer,
            'city_id'=>$faq->city_id,
            'status'=>1,
           ]);
        }

        dd('ss');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('db_1_to_db2', function (Blueprint $table) {
            //
        });
    }
};
