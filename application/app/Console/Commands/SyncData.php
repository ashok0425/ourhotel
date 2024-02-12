<?php

namespace App\Console\Commands;

use Hamcrest\Type\IsInteger;
use Hamcrest\Type\IsNumeric;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class SyncData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        DB::connection('mysql')->table('states')->delete();
        DB::connection('mysql')->table('cities')->delete();
        DB::connection('mysql')->table('amenities')->delete();
        DB::connection('mysql')->table('locations')->delete();
        DB::connection('mysql')->table('categories')->delete();
        DB::connection('mysql')->table('property_types')->delete();
        DB::connection('mysql')->table('faqs')->delete();
        DB::connection('mysql')->table('users')->delete();
        DB::connection('mysql')->table('blogs')->delete();
        DB::connection('mysql')->table('properties')->delete();
        DB::connection('mysql')->table('bookings')->delete();
        DB::connection('mysql')->table('rooms')->delete();
        DB::connection('mysql')->table('testimonials')->delete();


        //states
        $states=DB::connection("mysql_2")->table('countries')->get();
        foreach ($states as $key => $state) {
           DB::connection("mysql")->table('states')->insert([
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
           DB::connection('mysql')->table('cities')->insert([
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
           DB::connection('mysql')->table('amenities')->insert([
            'id'=>$amenity->id,
            'name'=>$name->name,
            'status'=>1,
            'thumbnail'=>$amenity->icon,
           ]);
        }


        //city locations

        $city_locations=DB::connection("mysql_2")->table('city_location')->get();
        foreach ($city_locations as $key => $city_location) {
           DB::connection('mysql')->table('locations')->insert([
            'id'=>$city_location->id,
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
             DB::connection('mysql')->table('categories')->insert([
            'id'=>$category->id,
              'name'=>$name->name,
              'status'=>1,
              'meta_keyword'=>$category->seo_title,
              'meta_title'=>$category->seo_title,
              'meta_description'=>$category->seo_description,
              'mobile_meta_keyword'=>$category->seo_title,
              'mobile_meta_title'=>$category->seo_title,
              'mobile_meta_description'=>$category->seo_description,
              'slug'=>Str::slug($name->name)
             ]);
          }


        //property types
        $types=DB::connection("mysql_2")->table('place_types')->get();
        foreach ($types as $key => $type) {
            $name=DB::connection("mysql_2")->table('place_type_translations')->where('place_type_id',$type->id)->first();
           DB::connection('mysql')->table('property_types')->insert([
            'id'=>$type->id,
            'name'=>$name->name,
            'category_id'=>$type->category_id,
            'status'=>1,
            'slug'=>Str::slug($name->name)
           ]);
        }


        //customer feeback for website
        $testimonials=DB::connection("mysql_2")->table('testimonials')->get();
        foreach ($testimonials as $key => $testimonial) {
            $name=DB::connection("mysql_2")->table('testimonial_translations')->where('testimonial_id',$testimonial->id)->first();
           DB::connection('mysql')->table('testimonials')->insert([
            'name'=>$name?->name,
            'position'=>$name->job_title,
            'status'=>$testimonial->status,
            'feedback'=>$name->content
           ]);
        }


        //customer feeback for hotels
        $testimonials=DB::connection("mysql_2")->table('reviews')->get();
        foreach ($testimonials as $key => $testimonial) {
            $user=DB::connection("mysql_2")->table('users')->where('id',$testimonial->id)->first();
           DB::connection('mysql')->table('testimonials')->insert([
            'name'=>$user?->name,
            'position'=>'',
            'status'=>$testimonial->status,
            'feedback'=>$testimonial->comment,
            'rating'=>$testimonial->score,
            'user_id'=>$testimonial->user_id,
            'property_id'=>$testimonial->place_id,
            'created_at'=>$testimonial->created_at,
            'updated_at'=>$testimonial->updated_at,

           ]);
        }


          //customer feeback for hotels
          $testimonials=DB::connection("mysql_2")->table('hotel_reviews')->get();
          foreach ($testimonials as $key => $testimonial) {
              $user=DB::connection("mysql_2")->table('users')->where('id',$testimonial->id)->first();
             DB::connection('mysql')->table('testimonials')->insert([
              'name'=>$user?->name,
              'position'=>'',
              'status'=>1,
              'feedback'=>$testimonial->feedback,
              'rating'=>$testimonial->rating,
              'user_id'=>$testimonial->user_id,
              'property_id'=>$testimonial->product_id,
              'created_at'=>$testimonial->created_at,
              'updated_at'=>$testimonial->updated_at,

             ]);
          }


        //   Tax data sync


        $taxes=DB::connection("mysql_2")->table('tax')->get();
        foreach ($taxes as $key => $tax) {
           DB::connection('mysql')->table('taxes')->insert([
            'price_min'=>$tax->price_min,
            'price_max'=>$tax->price_max,
            'percentage'=>$tax->percentage,
            'created_at'=>$tax->created_at,
            'updated_at'=>$tax->updated_at,

           ]);
        }


    // tour booking
        $tours=DB::connection("mysql_2")->table('tour_bookings')->get();
        foreach ($tours as $key => $tour) {
           DB::connection('mysql')->table('tour_bookings')->insert([
            'booking_id'=>$tour->booking_id,
            'tour_name'=>$tour->tour_name,
            'start_date'=>$tour->start_date,
            'end_date'=>$tour->end_date,
            'end_date'=>$tour->end_date,
            'end_date'=>$tour->end_date,
            'remark'=>$tour->remark,
            'status'=>$tour->status,
            'amount'=>$tour->amount,
            'paid_amount'=>$tour->paid_amount,
            'no_of_adult'=>$tour->adult,
            'no_of_child'=>$tour->children,
            'created_at'=>$tour->created_at,
            'updated_at'=>$tour->updated_at

           ]);
        }


        //notification message
        $notifications = DB::connection("mysql_2")->table('fcm_notify')->get();
        foreach ($notifications as $key => $notification) {
           DB::connection('mysql')->table('fcm_notifications')->insert([
               'title'=>$notification->title,
               'body'=>$notification->body,
               'userIds'=>$notification->user_ids,
               'user_count'=>100,
               'success_count'=>100,
               'created_at'=>now(),
               'updated_at'=>now()
           ]);
        }


         //corporates
         $corporates = DB::connection("mysql_2")->table('corporate')->get();
         foreach ($corporates as $key => $corporate) {
            DB::connection('mysql')->table('corporates')->insert([
                'user_id'=>$corporate->user_id,
                'name'=>$corporate->name,
                'company_name'=>$corporate->company_name,
                'gst_no'=>$corporate->gst_no,
                'address'=>$corporate->address,
                'year_book_day'=>$corporate->year_book_day,
                'month_book_day'=>$corporate->month_book_day,
                'location'=>$corporate->location,
            ]);
         }


        // Faqs
        $faqs=DB::connection("mysql_2")->table('faq')->get();
        foreach ($faqs as $key => $faq) {
           DB::connection('mysql')->table('faqs')->insert([
            'question'=>$faq->question,
            'answer'=>$faq->answer,
            'city_id'=>$faq->city_id,
            'status'=>1,
           ]);
        }


         // coupons
         $coupons=DB::connection("mysql_2")->table('coupon')->get();
         foreach ($coupons as $key => $coupon) {
            DB::connection('mysql')->table('coupons')->insert([
             'coupon_name'=>$coupon->coupon_name,
             'coupon_min'=>$coupon->coupon_min,
             'coupon_percent'=>$coupon->coupon_percent,
             'thumbnail'=>$coupon->thumb,
             'mobile_thumbnail'=>$coupon->mobile_image,
             'expired_at'=>$coupon->expired_at,
             'link'=>$coupon->link
            ]);
         }

          // Blogs
          $blogs=DB::connection("mysql_2")->table('posts')->get();
          foreach ($blogs as $key => $blog) {
             DB::connection('mysql')->table('blogs')->insert([
              'title'=>$blog->title??'No title',
              'slug'=>$blog->slug,
              'thumbnail'=>$blog->thumb??'no thumb',
              'slug'=>$blog->slug,
            //   'short_description'=>$blog->content,
              'long_description'=>$blog->content??'no desc',
              'meta_keyword'=>$blog->seo_title,
              'meta_description'=>$blog->seo_description,
              'meta_title'=>$blog->seo_title,
              'mobile_meta_keyword'=>$blog->seo_title,
              'mobile_meta_description'=>$blog->seo_description,
              'mobile_meta_title'=>$blog->seo_title,
              'status'=>$blog->status,
             ]);
          }

        // Users
        $users=DB::connection("mysql_2")->table('users')->get();
        foreach ($users as $key => $user) {
           DB::connection('mysql')->table('users')->insert([
            'id'=>$user->id,
            'name'=>$user->name??'Guest',
            'email'=>$user->email,
            'password'=>$user->password,
            'remember_token'=>$user->remember_token,
            'phone_number'=>$user->phone_number,
            'is_admin'=>$user->is_admin??0,
            'is_partner'=>$user->is_partner??0,
            'is_corporate'=>$user->is_corporate,
            'status'=>$user->status??1,
            'ip_id'=>$user->ip_id??'127.0.0.1',
            'created_at'=>$user->created_at,
            'updated_at'=>$user->updated_at,
            'is_agent'=>$user->is_agent??1,
            'fcm_token'=>$user->fcm_token,
            'app_fcm_token'=>$user->app_fcm_token,
            'isSeoExpert'=>$user->isSeoExpert
           ]);
        }


        //properties
        $places=DB::connection("mysql_2")->table('places')->where('user_id','!=',null)->get();
        foreach ($places as $key => $place) {
            $name=DB::connection('mysql_2')->table('place_translations')->where('place_id',$place->id)->value('name');
            $amenities = is_array($place->amenities) ? json_encode($place->amenities) : $place->amenities;
        $amenities = Str::isJson($amenities) ? $amenities : null;
           DB::connection('mysql')->table('properties')->insert([
            'id'=>$place->id,
            'property_id'=>$place->hotel_id??null,
            'city_id'=>$place->city_id,
            'state_id'=>$place->country_id,
            'owner_id'=>$place->user_id,
            'category_id'=>is_int((int)json_decode($place->category)[0])?json_decode($place->category)[0]:0,
            'property_type_id'=>json_decode($place->place_type)[0],
            'name'=>$name,
            'slug'=>$place->slug,
            'address'=>$place->address,
            'latitude'=>$place->lat,
            'longitude'=>$place->lng,
            'created_at'=>now(),
            'updated_at'=>now(),
            'amenities'=>$amenities,
            'price_range'=>$place->price_range,
            'opening_hour'=>$place->opening_hour,
            'description'=>$place->description,
            'thumbnail'=>$place->thumb,
            'gallery'=>Str::isJson($place->gallery)?$place->gallery :null,
            'rating'=>$place->rating,
            'meta_keyword'=>$place->seo_title,
            'meta_description'=>$place->seo_description,
            'meta_title'=>$place->seo_title,
            'mobile_meta_keyword'=>$place->seo_title,
            'mobile_meta_description'=>$place->seo_description,
            'mobile_meta_title'=>$place->seo_title,
           ]);
        }


      //   Rooms
      $rooms=DB::connection("mysql_2")->table('rooms')->where('hotel_id','!=',null)->get();
      foreach ($rooms as $key => $room) {
          $name=DB::connection('mysql_2')->table('room_translations')->where('room_id',$room->id)->value('name');
         DB::connection('mysql')->table('rooms')->insert([
          'id'=>$room->id,
          'property_id'=>$room->hotel_id??null,
          'name'=>$name,
          'slug'=>Str::slug($name),
          'hourlyprice'=>$room->hourlyprice,
          'onepersonprice'=>$room->onepersonprice,
          'twopersonprice'=>$room->twopersonprice,
          'threepersonprice'=>$room->threepersonprice,
          'discount_percent'=>$room->discount_percent,
          'created_at'=>$room->created_at,
          'updated_at'=>$room->updated_at,
          'beds'=>$room->beds,
          'size'=>$room->size,
          'adults'=>$room->adults,
          'children'=>$room->children,
          'amenity'=>Str::isJson($room->amenities)?$room->amenities :null,
          'gallery'=>Str::isJson($room->gallery)?$room->gallery :null,
          'no_of_room'=>$room->number,
          'no_of_booked_room'=>0
         ]);
      }



     // Bookings
     $bookings=DB::connection("mysql_2")->table('bookings')->get();
     foreach ($bookings as $key => $booking) {

        DB::connection('mysql')->table('bookings')->insert([
         'booking_id'=>$booking->booking_id??rand(1,90999099),
         'user_id'=>$booking->user_id,
         'user_id'=>$booking->user_id,
         'property_id'=>$booking->place_id,
         'no_of_adult'=>$booking->numbber_of_adult	??0,
         'no_of_child'=>$booking->numbber_of_children??1,
         'no_of_room'=>$booking->nummber_of_room??0,
         'no_of_night'=>$booking->no_of_night??1,
         'created_at'=>$booking->created_at,
         'updated_at'=>$booking->updated_at,
         'final_amount'=>$booking->amount,
         'total_price'=>$booking->amount,
         'discount'=>$booking->discountPrice,
         'coupon_code'=>$booking->coupon_code,
         'tax'=>$booking->tax,
         'name'=>$booking->name,
         'email'=>$booking->email,
         'phone_number'=>$booking->phone_number,
         'early_reason'=>$booking->early_reason,
         'cancel_reason'=>$booking->cancel_reason,
         'is_paid'=>$booking->is_paid!=''?$booking->is_paid:0,
         'booked_by'=>$booking->booked_by,
         'channel'=>$booking->booking_from,
         'booking_type'=>$booking->booking_type,
         'room_type'=>$booking->room_type,
         'refer_amount_spent'=>$booking->refer_amount_spent,
         'refer_id'=>$booking->refer_id,
         'payment_type'=>$booking->payment_type,
        ]);
     }


    }
}
