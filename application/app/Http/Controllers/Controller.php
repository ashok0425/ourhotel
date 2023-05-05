<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use File;
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function uploadImage($file)
    {
        if($file){
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid(). time() . '.' . $extension;
             $file->storeAs('uploads/',$filename,'public');
              return $filename;
        }
     return '';

    }

    public function deleteImage($path)
    {
        return File::delete($path);
    }
}
