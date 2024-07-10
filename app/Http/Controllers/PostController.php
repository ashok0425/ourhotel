<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Blog;

class PostController extends Controller
{
    public function list()
    {


        $posts = Blog::query()
            ->orderBy('id','desc')
            ->whereNotIn('id',[88,89,91,92])
            ->where('status', 1)->paginate(15);


        return view('frontend.post.blog_list', [
            'posts' => $posts,
        ]);
    }

    public function detail($slug)
    {
        $post = Blog::query()
            ->where('slug', $slug)
            ->first();

        if (!$post) abort(404);

        $related_posts = Blog::query()
            ->limit(3)
            ->latest()
            ->get();


        // SEO Meta
        return view('frontend.post.blog_detail', [
            'post' => $post,
            'related_posts' => $related_posts,
        ]);
    }
}
