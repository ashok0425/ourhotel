<?php

namespace App\Http\Controllers\API;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Testimonial;

class PostController extends Controller
{

    public function postInspiration()
    {
        $posts = Post::query()
            ->with('categories')
            ->where('type', Post::TYPE_BLOG)
            ->limit(10)
            ->get();

        return $this->response->formatResponse(200, $posts);
    }


    public function Testimonial(){

        $testimonials = testimonials()->map(function ($testimonial) {
            return [
                'id' => $testimonial->id,
                'name' => $testimonial->name,
                'job_title' => $testimonial->position,
                'content' => $testimonial->feedback,
                'status' => $testimonial->status,
                'avatar' => $testimonial->thumbnail,
            ];
        });
        return $this->success_response('Testimonial fetched successfully',$testimonials);
    }



    public function Bannerlist()
    {

        $data = coupons()->map(function ($coupon) {
            return [
                'id' => $coupon->id,
                "coupon_name"=>$coupon->coupon_name,
                "coupon_value"=> null,
                "coupon_min"=>$coupon->coupon_min,
                "coupon_percent"=> $coupon->coupon_percent,
                "mobile_image"=> $coupon->thumbnail,
                "thumb"=> $coupon->thumbnail,
                "expired_at"=> $coupon->expired_at,
                "descr"=> $coupon->descr,
                "link"=> $coupon->link,
            ];
        });
        return $this->success_response('Data fetched',$data,200);

    }
}
