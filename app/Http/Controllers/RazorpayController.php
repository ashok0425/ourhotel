<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{

    public function payWithRazorpay($booking)
    {

          return view('frontend.razorpay.order_payment_Razorpay', compact("booking"));

    }

   public function payment(Request $request, $booking_id)
    {
        $input = $request->all();
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {

                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                $uuid=session()->get('uuid');
                return redirect()->route('thanku',compact('uuid'));
            }
            catch (\Exception $e) {
                return  $e->getMessage();
                Session()->put('error',$e->getMessage());
                return redirect()->back();
            }
        }

    }

}
