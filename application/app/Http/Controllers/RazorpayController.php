<?php
namespace App\Http\Controllers;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;
use Redirect;
use auth;

class RazorpayController extends Controller
{

    public function payWithRazorpay(Request $request)
    {
        if($request->get('booking_id') && $request->get('booking_id') > 0) {

          //$booking = Booking::findOrFail($request->get('booking_id'));
          return view('frontend.razorpay.order_payment_Razorpay');
        }
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
                // Do something here for store payment details in database...
                if(Session::get('payment_type') == 'cart_payment'){
                    $this->checkout_done($booking_id, $response['id']);
                }
                return redirect()->route('user_my_place')->with('success', 'Thanks for your hotel booking with NSN Hotels!');
            }
            catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }

    }

 public function payWithRazorpays(Request $request)
    {


          //$booking = Booking::findOrFail($request->get('booking_id'));
          return view('frontend.razorpay.order_payment_Razorpay');

    }

   public function payments(Request $request, $booking_id)
    {
        $input = $request->all();
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            $payment_detalis = null;
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount']));
                // Do something here for store payment details in database...
                if(Session::get('payment_type') == 'cart_payment'){
                    $this->checkout_done($booking_id, $response['id']);
                }
                return redirect()->route('user_my_place')->with('success', 'Thanks for your hotel booking with NSN Hotels!');
            }
            catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }
        }

    }

    //redirects to this method after a successfull checkout
    public function checkout_done($order_id, $razorpay_payment_id)
    {
        if(Session::get('payment_type') == 'cart_payment'){
            $order = Booking::findOrFail($order_id);
            $order->status = '1';
            $order->payment_id = $razorpay_payment_id;
            $order->save();
        }
        return redirect()->route('user_my_place')->with('success', 'Thanks for your hotel booking with NSN Hotels!');


    }
}
