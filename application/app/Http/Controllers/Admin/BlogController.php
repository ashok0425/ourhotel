<?php

namespace App\Http\Controllers\Admin;

use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Str;
class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs=Blog::query()->orderBy('id','desc')->get();
        return view('admin.blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:225',
            'thumbnail'=>'required|max:2048',
        ]);
        $path=$this->uploadImage($request->thumbnail);
        $slug=Str::slug($request->title);
       $blog=new Blog;
       $blog->title=$request->title;
       $blog->slug=$slug;
       $blog->short_description=$request->short_description;
       $blog->long_description=$request->long_description;
       $blog->status=$request->status;
       $blog->thumbnail=$path;
       $blog->meta_keyword=$request->meta_keyword;
       $blog->meta_title=$request->meta_title;
       $blog->meta_description=$request->meta_description;
       $blog->mobile_meta_keyword=$request->mobile_meta_keyword;
       $blog->mobile_meta_title=$request->mobile_meta_title;
       $blog->mobile_meta_description=$request->mobile_meta_description;
       $blog->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Blog Create Sucessfully'
       );
       return redirect()->route('admin.blogs.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit',compact('blog'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title'=>'required|max:225',
        ]);
        $path=$this->uploadImage($request->thumbnail);
        $blog->title=$request->title;
        $blog->short_description=$request->short_description;
        $blog->long_description=$request->long_description;
        $blog->status=$request->status;
       $blog->thumbnail=$path?$path:$blog->thumbnail;
       $blog->meta_keyword=$request->meta_keyword;
       $blog->meta_title=$request->meta_title;
       $blog->meta_description=$request->meta_description;
       $blog->mobile_meta_keyword=$request->mobile_meta_keyword;
       $blog->mobile_meta_title=$request->mobile_meta_title;
       $blog->mobile_meta_description=$request->mobile_meta_description;
       $blog->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Blog Updated Sucessfully'
       );
       return redirect()->route('admin.blogs.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
       $blog->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Blog Deleted Sucessfully'
       );
       return redirect()->route('admin.blogs.index')->with($notification);
    }
}
