<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Category::query()->orderBy('id','desc')->get();
        return view('admin.category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:225',
        ]);
        $slug=Str::slug($request->name);

       $category=new Category;
       $category->name=$request->name;
       $category->slug=$slug;
       $category->status=$request->status;
       $category->meta_keyword=$request->meta_keyword;
       $category->meta_title=$request->meta_title;
       $category->meta_description=$request->meta_description;
       $category->mobile_meta_keyword=$request->mobile_meta_keyword;
       $category->mobile_meta_title=$request->mobile_meta_title;
       $category->mobile_meta_description=$request->mobile_meta_description;
       $category->save();
       $notification=array(
        'type'=>'success',
         'message'=>'Category Create Sucessfully'
       );
       return redirect()->route('admin.categories.index')->with($notification);

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'=>'required|max:225',
        ]);
        $slug=Str::slug($request->name);

       $category->name=$request->name;
       $category->slug=$slug;
       $category->status=$request->status;
       $category->meta_keyword=$request->meta_keyword;
       $category->meta_title=$request->meta_title;
       $category->meta_description=$request->meta_description;
       $category->mobile_meta_keyword=$request->mobile_meta_keyword;
       $category->mobile_meta_title=$request->mobile_meta_title;
       $category->mobile_meta_description=$request->mobile_meta_description;

       $category->save();

       $notification=array(
        'type'=>'success',
         'message'=>'Category Updated Sucessfully'
       );
       return redirect()->route('admin.categories.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
       $category->delete();
       $notification=array(
        'type'=>'success',
         'message'=>'Category Deleted Sucessfully'
       );
       return redirect()->route('admin.categories.index')->with($notification);
    }
}
