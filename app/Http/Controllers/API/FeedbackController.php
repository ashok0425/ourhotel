<?php

namespace App\Http\Controllers\API;


use App\Commons\Response;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{

    public function index($property_id=null){
        if($property_id){
            $feedbacks = Testimonial::with('property')->with('user')->latest()->limit(20)->get();
        }else{
            $feedbacks = Testimonial::with('property')->with('user')->where('user_id',Auth::user()->id)->latest()->get();
        }

        $feedbacks=$feedbacks->map(function($feedback){
          return  [
            'id'=>$feedback->id,
            'name'=>$feedback->name??$feedback->user->name??'Guest',
            'thumbnail'=>$feedback->thumbnail??$feedback->user->profile_photo_path??null,
            'feedback'=>$feedback->feedback,
            'rating'=>$feedback->rating,
            'hotel_name'=>$feedback->property->name??'Property Deleted',
            'hotel_id'=>$feedback->property_id??'',
            'created_at'=>$feedback->created_at??today()
           ];
        });

        return $this->success_response('Feedback fetched',$feedbacks);
     }

     public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'feedback' => 'nullable',
            'property_id'=>'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }
            return $this->error_response($datas, '', 400);

        }
       $feedback=new Testimonial();
       $feedback->user_id=Auth::user()->id;
       $feedback->property_id=$request->property_id;
       $feedback->name=Auth::user()->name;
       $feedback->feedback=$request->feedback;
       $feedback->rating=$request->rating;
       $feedback->save();

        return $this->success_response('Thank you for your feedback',$feedback);
     }


     public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'rating' => 'required',
            'feedback' => 'nullable',
            'property_id'=>'nullable',
            'id'=>'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }
            return $this->error_response($datas, '', 400);

        }
       $feedback=Testimonial::findorFail($request->id);
       $feedback->name=Auth::user()->name;
       $feedback->feedback=$request->feedback;
       $feedback->rating=$request->rating;
       $feedback->save();

        return $this->success_response('Feedback updated successfully',$feedback);
     }


     public function delete(Request $request){
        $validator = Validator::make($request->all(), [
            'id'=>'required'
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $datas = [];
            foreach ($errors as $key => $value) {
                $datas[] = $value[0];
            }
            return $this->error_response($datas, '', 400);

        }
       $feedback=Testimonial::find($request->id);
       $feedback->delete();

        return $this->success_response('Feedback delete successfully',$feedback);
     }
}
