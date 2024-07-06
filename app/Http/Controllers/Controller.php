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
            $file->storeAs('uploads/',$filename,'s3');
              return $filename;
        }
     return '';

    }

    public function deleteImage($path)
    {
        return File::delete($path);
    }

    protected function success_response(  $message = null,$data=null, int $code = 200)
	{
		return response()->json([
			'status' => 'success',
			'message' => $message,
			'data' => $data
		], $code);
	}


	protected function error_response($message = null,$data=null, int $code)
	{
		return response()->json([
			'status' => 'error',
			'message' => $message,
			'data' => $data
		], $code);
	}
}
