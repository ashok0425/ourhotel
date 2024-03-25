@push('style')
@endpush
@push('style')
<link type="text/css" rel="stylesheet" href="{{asset('frontend/css/plugins.css')}}">
@endpush
@extends('frontend.layouts.master')
@section('main')

<div class="partner-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h2>List your any types <br> of <span>properties</span> on <br> nsnhotels.com</h2>
                <p>Spare your 5 minutes and fill the below form</p>
            </div>
            <div class="col-lg-5">
                <div class="partner-meta">
                    <h4>Create hotel listing with NSN Hotels</h4>
                    <ul class="list-styled">
                        <li>It's free to live your property in our portal</li>
                        <li>24/7 team support by what’s up/phone/email</li>
                        <li>Set your own price for guests</li>
                        <li>Set your goals and achieve your target</li>
                    </ul>
                    <h5>Special Package for more business - Start Booster package with many free gifts</h5>
                    <p>For more information connect with our team</p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="partnerform">
    <div class="whytopartnerform">
        <div class="container">
            <h1 class="headingtext">Become A Partner</h1>

            <div class="row">
                <div class="col-12 col-sm-8 col-md-8 order-sm-1 order-md-1 order-2">
                    <form action="{{route('place_create')}}" method="post" class="partnerinnerform">
                    @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="partner_name">Partner Name *</label>
                                    <input type="text" name="partner_name" class="form-control" id="partner_name" required />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="place_name">{{__('Property Name')}} *</label>
                                    <input type="text" id="place_name" name="{{$language_default['code']}}[name]" class="form-control" required />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="place_email">Email *</label>
                                    <input type="email" name="email" class="form-control" id="place_email" required />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="place_number">Phone *</label>
                                    <input type="tel" name="phone_number" class="form-control" id="place_number" required />
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="state">State *</label>
                                    <select class="form-control" name="country_id" id ="select_country">
                                        <option value="State">Select State<option>

                                        @foreach($countries as $country)
                                        <option value="{{$country['id']}}" >{{$country['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label>Select City</label>
                                    <select class="form-control" name="city_id" id= "select_city">
                                        <option value="City">Select City<option>
                                        @foreach($cities as $city)
                                        @if($city['name'] != " ")
                                        <option value="{{$city['id']}}" >{{$city['name']}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="lis_category">{{__('Category')}} *</label>
                                    <select class="form-control" name="category[]">
                                        <option value="Category">Select Category<option>
                                        @foreach($categories as $cat)
                                        <option value="{{$cat['id']}}" >{{$cat['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="lis_place_type">{{__('Property Type')}} *</label>
                                    <select class="form-control" name="place_type[]">
                                        <option value="Select Place">Select Place<option>
                                        @foreach($place_types as $cat)
                                        <optgroup label="{{$cat['name']}}">
                                        @foreach($cat['place_type'] as $type)
                                        <option value="{{$type['id']}}" >{{$type['name']}}</option>
                                        @endforeach
                                        </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <textarea type="text" class="form-control" id="pac-input" placeholder="{{__('Full Address')}}"  name="address" autocomplete="off" required></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12">
                                  <h6>Please download the Agreement and revert at admin@nsnhotels.com with the signature copy of the authorized  person to get your property live</h6>
                                 <div class="form-group">
                                     <label class="checkbox-inline">

                                        <input type="checkbox" name="agree" value="1"> I accept <a href="{{asset('hotel_term_condition.pdf')}}" class="link" download>Terms and Conditions</a>

                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn commonbtn bluebtn w-100 text-white custom-fw-700">SUBMIT REQUEST</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-sm-4 col-md-4 order-sm-2 order-md-2 order-1">
                    <img src="assets/images/becomepartnerb.png" class="img-fluid" alt="NSN Hotels" />
                </div>
            </div>
        </div>
    </div>
    <div class="partnerformcontent">
        <div class="container">
            <div class="headingtext">How does it work?</div>
            <div class="row">
                <div class="col-12 col-sm-4 col-md-4 howworkbox">
                    <div class="howitwork">
                        <i class="far fa-building"></i>
                        <div class="httext">Set up your Property</div>
                        <p>Explain what’s unique, show off with photos, and set the right price.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 howworkbox">
                    <div class="howitwork">
                        <i class="far fa-building"></i>
                        <div class="httext">Get the Perfect Match</div>
                        <p>We’ll connect you with travelers from home and abroad.</p>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 howworkbox">
                    <div class="howitwork">
                        <i class="far fa-building"></i>
                        <div class="httext">Start Earning</div>
                        <p>We’ll help you collect payment, deduct a commission, and send you the balance.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="whywearepartner">
        <div class="container">
            <div class="headingtext">Why Become A Partner?</div>
            <div class="row">
                <div class="col-12 col-sm-4 col-md-4 whyweare">
                    <div class="whywearebox">
                        <div class="whyweareboximg">
                            <img src="assets/images/whytopartner.png" alt="Why Partner" />
                        </div>
                        <div class="httext">Earn an Additional Income</div>
                        <p>Every hotelier and host faces the question of how to increase revenue and profit without raising prices or overspending. When immersed in day-to-day operations, it can be hard to see the big picture, and getting the right answers can be complex. While there are many ways to increase your hotel revenue depending on your property’s needs.  So connecting with an OTA like NSN https://nsnhotels.com where you do not have to invest anything and t=you will start earning from us.
                </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 whyweare">
                    <div class="whywearebox">
                        <div class="whyweareboximg">
                            <img src="assets/images/whytopartnerb.png" alt="Why Partner" />
                        </div>
                        <div class="httext">Open your Network</div>
                        <p>Expanding your professional network can be challenging. Before you get started, you’ll need a clear, concise understanding of what sets your business apart from competitors and what you can bring to the table. We’ll explore ways to meet travel industry professionals, introduce them to your business and start reaping the rewards of positive industry relationships. </p>
                    </div>
                </div>
                <div class="col-12 col-sm-4 col-md-4 whyweare">
                    <div class="whywearebox">
                        <div class="whyweareboximg">
                            <img src="assets/images/whytopartnerc.png" alt="Why Partner" />
                        </div>
                        <div class="httext">Practice your Language</div>
                        <p>It  means putting your guests at ease and giving them confidence and understanding the hospitality experience you are offering. Creating in the guest that sense of security and confidence that he or she will be understood, is one of the key elements in setting guests at ease.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
  $(window).load(function(){
                 @if(session()->has('success'))
   swal("Thanks!", "Thanks for the registration with NSN Hotels. Our team will contact you soon..", "success");


@endif

  });
</script>

@stop
@push('scripts')
<script src="{{asset('frontend/jss/page_place_new.js')}}"></script>
@endpush
