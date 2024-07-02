@extends('frontend.layouts.master')
@section('main')
<div class="nsn-corporate">
  <div class="container" >

    <div class="corporate-inner">
        <div class="row">
          <div class="col-lg-6 align-center" >
            <div class="corporate-list p-3" style="color: white;background: rgba(7, 136, 144, 0.5);border-radius: 5px;">
                <h2 class="text-center">Corporate Offers</h2>
              <ul>
                <li>Exclusive Corporate Rates</li>
                <li>Seamless Business Stay</li>
                <li>Conference Rooms</li>
                <li>Corporate Hotels with the Conference Rooms</li>
                <li>Set Your employees with travel policies</li>
                <li>Detail reports on company Spends</li>
                <li>Seamless Booking of Accommodation</li>
                <li>Get Automated invoicing</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-6">
            <form method="POST">
                <x-errormsg/>
                @csrf
              <h2>NSN BUSINESS</h2>
              <div class="form-group">
                <label for="yname">Name</label>
                <input type="text" class="form-control" id="yname" name ="name" placeholder="Your name">
              </div>
              <div class="form-group">
                <label for="cname">Company</label>
                <input type="text" class="form-control" id="cname"name ="company" placeholder="Company name">
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name ="email" placeholder="Email">
              </div>
              <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" class="form-control" id="mobile" name ="mobile" placeholder="Company name">
              </div>
              <div class="form-group">
                <label for="city">Address</label>
                <input type="text" class="form-control" id="city" name = "city" placeholder="Company name">
              </div>
              <div class="text-center pt-3 mt-5">
                <button type="submit" class="btn btn-primary nsn-btn">Register Now</button>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>


<div class="nsn-corporate-info">
  <div class="container">
    <div class="corporate-info card">
      Corporate Stay offered by NSN in India with best price and best location.
      <h5>We Promise</h5>
      <p>Easy check-in access to our properties with up to big savings, manage all your company bookings on a single portal, which overcome to third-party agents.</p>
      <h5>Save Time</h5>
      <p>With NSN Corporate you can have all your bookings at your fingertips anytime you need them either from your own or by contacting our team.</p>
      <h5>Transparency</h5>
      <p>Direct invoices  from NSN without any additional request, and always genuine.</p>
      <h5>GST</h5>
      <p>Hassle free GST <br> Round the clock smooth check in <br> Claim input credit in every state <br> One time registration only</p>
    </div>
  </div>
</div>

@stop
