<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public $image;
    public function upload(Request $request)
    {
        if ($request->hasFile('image')) {

            

           $validate= Validator::make($request->all(), [
                'image' => 'mimes:png,jpg,gif,jpeg,webp|max:2048'
            ]);
            if($validate->fails()){
                return [
                    "code" => 200,
                    "status" => "error",
                    "file_name" => 'File type must be png,jpg,gif,jpeg,webp and less than 2MB'
                ];
            }

            $image = $request->file('image');
            $file_name = $this->uploadImage($image, '');
            return [
                "code" => 200,
                "status" => "success",
                "file_name" => $file_name
            ];
        }

        return [
            "code" => 404,
            "status" => "no file"
        ];
    }


    public function delete(Request $request)
    {
        if(isset($request->model)&&$request->model!=null){
            if($request->model=='property'){
                $property=Property::find($request->id);
            }else{
                $property=Room::find($request->id);
            }
            $gallery=json_decode($property->gallery);
         

           $this->image=$request->image;
           $new_gallery= array_filter($gallery, function($item){
                 return $item!=$this->image;
                 
              });
           $property->gallery=json_encode($new_gallery);
           $property->save();
        }
        if ($request->image) {
           if(file_exists('storage/uploads/'.$request->image)){
            File::delete('storage/uploads/'.$request->image);
           }
            return [
                "code" => 200,
                "status" => "success",
            ];
        }

        return [
            "code" => 404,
            "status" => "no file"
        ];
    }
}