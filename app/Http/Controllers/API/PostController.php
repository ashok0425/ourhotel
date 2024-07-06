<?php

namespace App\Http\Controllers\API;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Post;

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
}
