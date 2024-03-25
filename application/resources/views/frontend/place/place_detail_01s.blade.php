@extends('frontend.layouts.template-place')

@push('style')
<style>
    :root{
        --color-orange:rgb(255, 136, 0);
    }
    .fa-star{
        color:var(--color-orange)!important;
    }
    .custom-bg-orange{
        background:var(--color-orange)!important;

    }
  .star-container{display:flex;align-items:start;justify-content:center;flex-direction:row-reverse}.radio{display:none}.label{width:50px;height:50px;display:block;text-align:center;transition:0.3s;cursor:pointer;color:#ddd;border-radius:20px;display:flex;align-items:center;justify-content:center;margin:1px}.star{transition:0.3s;font-size:3rem}.star:hover{color:var(--color-orange)!important;transform:scale(1.3,1.3)}.radio:checked~label .star{color:var(--color-orange)!important;transform:scale(1.3,1.3)}.radio:checked~label:hover .star{transform:scale(1,1)!important}.radio:checked~label:hover .star{color:var(--color-orange)!important}
    .comment-thread {
     
      margin: auto;
      background-color: #fff;
      border: 1px solid transparent; /* Removes margin collapse */
  }
  .m-0 {
      margin: 0;
  }
  
  .note-group-image-url,.note-modal-footer{
    display: none;
  }
  /* Comment */
  
  .comment {
      position: relative;
      margin: 20px auto;
  }
  .comment-heading {
      display: flex;
      align-items: center;
      height: 50px;
      font-size: 14px;
  }
  .comment-voting {
      width: 20px;
      height: 32px;
      border: 1px solid rgba(0, 0, 0, 0.2);
      border-radius: 4px;
  }
  .comment-voting button {
      display: block;
      width: 100%;
      height: 50%;
      padding: 0;
      border: 0;
      font-size: 10px;
  }
  .comment-info {
      color: rgba(0, 0, 0, 0.5);
      margin-left: 10px;
  }
  .comment-author {
      color: rgba(0, 0, 0, 0.85);
      font-weight: bold;
      text-decoration: none;
  }
  .comment-author:hover {
      text-decoration: underline;
  }
  .replies {
      margin-left: 20px;
  }
  
  /* Adjustments for the comment border links */
  
  .comment-border-link {
      display: block;
      position: absolute;
      top: 50px;
      left: 0;
      width: 12px;
      height: calc(100% - 50px);
      border-left: 4px solid transparent;
      border-right: 4px solid transparent;
      background-color: rgba(0, 0, 0, 0.1);
      background-clip: padding-box;
  }
  .comment-border-link:hover {
      background-color: rgba(0, 0, 0, 0.3);
  }
  .comment-body {
      
  }
  .replies {
      margin-left: 28px;
  }
  
  /* Adjustments for toggleable comments */
  .comment img{
    max-width: 120px!important;
    max-height:130px!important;
  
  }
  details.comment summary {
      position: relative;
      list-style: none;
      cursor: pointer;
  }
  details.comment summary::-webkit-details-marker {
      display: none;
  }
  details.comment:not([open]) .comment-heading {
      border-bottom: 1px solid rgba(0, 0, 0, 0.2);
  }
  .comment-heading::after {
      display: inline-block;
      position: absolute;
      right: 5px;
      align-self: center;
      font-size: 12px;
      color: rgba(0, 0, 0, 0.55);
  }
  
  
  /* Adjustment for Internet Explorer */
  
  @media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
      /* Resets cursor, and removes prompt text on Internet Explorer */
      .comment-heading {
          cursor: default;
      }
      details.comment[open] .comment-heading::after,
      details.comment:not([open]) .comment-heading::after {
          content: " ";
      }
  }
  
  /* Styling the reply to comment form */
  
  .reply-form textarea,.reply-form textarea,  .reply-forms textarea {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
      font-size: 16px;
      width: 100%;
      max-width: 100%;
      margin-top: 15px;
      margin-bottom: 5px;
  }
  
  
  
  </style>
@endpush
@section('main')

<div class="nsnhotelshotelsdetailsbanner pt-3">
    <div class="row m-0">
        <div class="col-12 col-sm-7 col-md-7 align-self-center">
            <div id="nsnhotelsslider" class="owl-carousel">
                @if(isset($place->gallery))
                    @foreach($place->gallery as $gallery)
                    <div class="nsnhotelsbanner">
                        <img src="{{getImageUrl($gallery)}}" alt="{{$place->PlaceTrans->name}}" class="img-responsive" width="1080" height="1080"/>
                    </div>
                    @endforeach
                    @else
                     <div class="nsnhotelsbanner">
                        <img src="https://via.placeholder.com/1280x480?text=NSN" alt="{{$place->PlaceTrans->name}}" class="img-responsive" width="1920" height="576"/>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 col-sm-5 col-md-5">
			<div class="bookingonline">
				@if($place->booking_type === \App\Models\Booking::TYPE_BOOKING_FORM)
				<div class="nsnhotelsleftsearch">
					<div class="nsnhotelsleftproperty">Only {{ $inventory_room }} Room Left</div>
					<form class="leftsearchform" name="bookRoomForm">
						@csrf
						<div class="searchboxtitle">Booking Online</div>
						<div class="row">
							<div class="col-6 col-sm-6 col-md-6">
								<div class="form-group">
									<label>Room Type:</label>
									<select class="form-control" name="room_type" id="room_type">
										<option value="1" selected >Select Room</option>
										@php $i = 0; @endphp
										@foreach($place->roomsData as $room)
											<option value="{{$room->id}}" @if($i ==0) selected="" @endif>{{$room->name}} - ₹ {{$room->onepersonprice}} </option>
										@php $i++; @endphp
										@endforeach
								
									</select>
								</div>
							</div>
							<div class="col-6 col-sm-6 col-md-6">
								<div class="form-group booking_type_div">
									<label>Booking Type:</label>
									<select class="form-control" name="booking_type" id="booking_type" >
										<option value="1">Select Booking Type</option>
									
										<option value="night_price" selected>Night Price</option>
											@if(isset($place->roomsData->first()->onepersonprice))
							<option value="hourlyprice" >3 Hours Price</option>
						@endif
										
									</select>
								</div>
							</div>
							<div class="col-6 col-sm-6 col-md-6">
								<div class="form-group">
									<label>No. of Room:</label>
									<select class="form-control" name="room_no" id="room_no">
										<option value="1" selected>No. of Room</option>
										@php $f = 0; @endphp
										@foreach($place->roomsData as $roomNo)
											@for ($i = 1; $i <= $roomNo->number; $i++)
												<option value="{{ $i }}" @if($i == 1) selected="" @endif >{{ $i }}</option>
											@endfor
										@endforeach
										@php $f++; @endphp
									</select>
								</div>
							</div>
						<div class="col-6 col-sm-6 col-md-6">
								<div class="form-group bookdate-container">
									<label>Check-In / Check Out</label>
									 <input type="text" class="form-control" autocomplete="off" placeholder="Date In-Out" name="bookdates" id="bookdates" value=""/ onchange="cal()">
								</div>
							</div>
						</div>
						
			<!--			<div class="row">
							<div class="col-6 col-sm-6 col-md-6">
								<div class="form-group bookdate-container">
									<label>Check In</label>
									 <input type="text" class="form-control" autocomplete="off" placeholder="Date In-Out" name="bookdates" id="bookdates" value=""/ onchange="cal()">
								</div>
							</div>
						   <div class="col-6 col-sm-6 col-md-6">
								<div class="form-group bookdate-container">
									<label>Check Out</label>
									 <input type="text" class="form-control" autocomplete="off" placeholder="Date In-Out" name="bookdates" id="bookdates" value=""/ onchange="cal()">
								</div>
							</div>
						</div>-->
						
						
						<div class="row">
							<div class="col-6 col-sm-6 col-md-6">
								<div class="form-group">
									<label>Adult:</label>
									<input type="number" class="form-control" name="numbber_of_adult" id="AdultsAllowed" min="1" max="100" value="1" selected>
									<span id="errorshow"></span>
								</div>
							</div>
							<div class="col-6 col-sm-6 col-md-6">
								<div class="form-group">
									<label>Children:</label>
									<input type="number" class="form-control" name="numbber_of_children"  id="numbber_of_children" min="0" max="4" value="0" >
								</div>
							</div>
						</div>
						<div class="row m-0">
							<div class="form-group">
								<label data-toggle="tooltip" data-placement="top" title="Extra Charges is Applicable depends upon the Availability of Rooms."><input type="checkbox" name="" id="" /> Request of early check in/check out:</label>
							</div>
						</div>
						<div class="form-group">
							<label>Meal Plans (Optional)</label>
							<select id="meals" name="meals" class="form-control" >
								<option value="">Select Meal Type</option>
								@foreach($meals as $meal)
									<option value="{{$meal->id}}" selected >{{$meal->meal->type. ' , Price-'.$meal->price}}</option>
								@endforeach
							</select>
									@foreach($meals as $meal)
								<input type="hidden" name ="{{$meal->id}}" id="{{$meal->id}}" value="{{$meal->price}}">                                                                         
									@endforeach
								<input type="hidden" name="place_id" value="{{$place->id}}">
						</div>
						<div class="form-group mb-0">   
							<div class="row">
								<div class="col-12 col-sm-6 col-md-6 totalpricelabel">
									<label>Total Price:</label>
								</div>
								<div class="col-12 col-sm-6 col-md-6 readonlyforminput inrsymbol">
									<span><input type="text" name="price" value="0" id="price" readonly></span> 
								</div>
							</div>
							<div class="row">
								<div class="col-12 col-sm-6 col-md-6 totalpricelabel">
									<label>Apply Coupon Code:</label>
								</div>
								<div class="col-12 col-sm-6 col-md-6 readonlyforminput inrsymbol">
									<span><input type="text" name="ccode" id="cprice" value="" placeholder="Enter Code"></span> 
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-12 col-sm-6 col-md-6 paybleamount">
									<label>Payable Amount: <span class="smalltax" id="tax_area"></span></label>
								</div>
								<div class="col-12 col-sm-6 col-md-6 readonlyforminput">
									<p id="grand_totals"style =" background: rgb(255,255,255);border: none;width: auto!important;max-width: 100%;color: rgb(0,0,0);
    text-align: right;padding: 10px 15px;"
   
></p>
									<input type="hidden" name="grand_total" value="0" id="grand_total" readonly>
									<input type="hidden"  name="grand_total" id="final_total" readonly>
								</div>
							</div>
						</div>
						<!--<div class="form-group">-->
						<!--	<div class="row">-->
						<!--		<div class="col-6 readonlyforminput1">-->
						<!--			<span><input type="text" name="coupon" placeholder="Add Coupon"></span>-->
						<!--		</div>-->
						<!--		<div class="col readonlyforminput1">-->
						<!--			<input type="submit" value="Submit Coupon" class="btn btn-primary">-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
					
						
						@guest()
						<div class="form-group">
							<button type="button"  class="nsnbooknowbt" onclick="window.location='{{route('user_login')}}'" >Login Now</button>
							
						</div>
						@else
						<div class="form-group">
							<div class="row">
								<!--<div class="col-12 col-sm-6 col-md-6">
									<!--<button class="nsnbooknowbt" onclick="showBookingDetail(event)" >Book Now <span>&amp;</span> Pay At Hotel</button>-->
								</div>
								<div class="col-12 col-sm-12 col-md-12">
									<button class="nsnbooknowbt" onclick="showBookingDetail(event)" >Book Now</button>
								</div>
							</div>
						</div>
						@endguest
						<input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_BOOKING_FORM}}">
						<input type="hidden" name="place_id" value="{{$place->id}}">
						@if(isset($place->roomsData->first()->onepersonprice))
						
							<input type="hidden" name="hourlyprice" id="hourlyprice" value="{{$place->roomsData->first()->hourlyprice}}">
						@endif
											
					</form>
				</div>
				@endif
			</div>
		</div>
    </div>
</div>
<div class="nsnhotelsdetails">
	<div class="container">

        @include('frontend.place.review',$place)
		<div class="row">
			<div class="col-12 col-sm-12 col-md-12">
				<div class="nsnhotelstitle">
					<h1 class="nsnhotelsdetailsname">{{$place->PlaceTrans->name}}</h1>
					<p class="locationtext">{{$place->address}}</p>
					
					<div class="nsnhotelsgetdirection">
						<a href="https://maps.google.com/?q={{$place->address}}" target="_blank" rel="nofollow" class="commonbtn bluebtn">Get Direction</a>
					</div>
				</div>
		  <!--   	<ul class="locatingnavi">-->
				<!--	<p>Transportation :</p>-->
				<!--	<li class="railway"> {{$place->railway_station}} </li>-->
				<!--	<li class="airport">{{$place->airport}}</li>-->
					<!--<li class="metro">{{$place->metro_station}}</li>-->
				<!--	<li class="mall">{{$place->other_place}}</li>-->
				<!--	<li class="church">{{$place->bus_stop}}</li>-->
					<!--<li class="mall">{{$place->shopping_complex}}</li>-->
				<!--</ul>-->
				<!--<div class="container bg1 mb-3"><p>Transportation :</p>-->
				
				<!--<div class="row">-->
					
				<!--	<div class="col-md-auto py-2"><i class="fa-solid fa-train"></i> {{$place->railway_station}} </div>-->
				<!--	<div class="col-md-auto py-2"><i class="fa-solid fa-plane-arrival"></i> {{$place->airport}}</div>-->
					<!--<li class="metro">{{$place->metro_station}}</li>-->
				<!--	<div class="col-md-auto py-2"><i class="fa-solid fa-store"></i> {{$place->other_place}}</div>-->
				<!--	<div class="col-md-auto py-2"><i class="fa-solid fa-church"></i> {{$place->bus_stop}}</div>-->
					<!--<li class="mall">{{$place->shopping_complex}}</li>-->
				<!--</div></div>-->
				<div class="container bg1 py-2"><p>Transportation :</p>
				<div style="font-size:13.6px" class="row justify-content-center">
					
					<div class="col-md-auto py-2"><i class="fa-solid fa-train"></i> {{$place->railway_station}} </div>
					<div class="col-md-auto py-2"><i class="fa-solid fa-plane-arrival"></i> {{$place->airport}}</div>
					<!--<li class="metro">{{$place->metro_station}}</li>-->
					<div class="col-md-auto py-2"><i class="fa-solid fa-store"></i> {{$place->other_place}}</div>
					<div class="col-md-auto py-2"><i class="fa-solid fa-church"></i> {{$place->bus_stop}}</div>
					<!--<li class="mall">{{$place->shopping_complex}}</li>-->
				</div></div>
				
				<div class="nsnhotelsinnerabout">
					<p>{!! $place->description !!}</p>
				</div>
				<div class="list-single-main-item fl-wrap" >
					<div class="list-single-main-item-title fl-wrap">
						<h3>{{__('Amenities')}}</h3>
					</div>
                    
					<div class="nsnhotelsamenities">
						<ul class="nsnhotelsamenitiesul">
							@foreach($amenities as $key => $item)
								@if($key < 12)
								<li class="place__amenities"><img src="{{getImageUrl($item->icon)}}" alt="{{$item->name}}" width="26" height="26">
								<span>{{$item->name}}</span></li>
								@endif
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div  class="text-center container py-2">
			<iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBhUo6qphOQSK0rjDXr1pU0EdOGHu_CMP0
    &q={{$place->address}}" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
<!--			<iframe-->
<!--  width="600"-->
<!--  height="350"-->
<!--  style="border:0"-->
<!--  loading="lazy"-->
<!--  allowfullscreen-->
<!--  referrerpolicy="no-referrer-when-downgrade"-->
<!--  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBhUo6qphOQSK0rjDXr1pU0EdOGHu_CMP0-->
<!--    &q={{$place->address}}">-->
<!--</iframe>-->
			</div>
			           
  		</div>
	</div>
</div>
<form action="" method="get" id="date_form">
    <input type="hidden" name="start_date" id="start_date" value="{{$start_date}}" />
    <input type="hidden" name="end_date" id="end_date" value="{{$end_date}}" />
</form>
<div class="modalPopupbook">
    <div class="popup-inner nsnhotelspersonalinformation">
        <div class="close-search"><i class="fa fa-times" aria-hidden="true"></i></div>
        <div class="httext">Review Your Booking</div>
        <div class="row">
            <div class="col-12 col-sm-7 col-md-7 personalinformation">
                <form class="personalinformationform" action="{{ route('payment.checkout') }}" role="form" method="POST" id="checkout-form">
                    <div class="httext">Your Personal Information</div>
                    @csrf
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="form-group firsticon icons">
                                <label>User Name<span style = "color:red">*</span></label>
                                <input type="text" value="{{Auth::user()->name ?? ""}}" name="name" id="" placeholder="First Name *" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="form-group emailicon icons">
                                <label>Email ID(Optional)</label>
                                <input type="email" value="{{Auth::user()->email ?? ""}}" name="email" id="" placeholder="Email " class="form-control"  />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6">
                            <div class="form-group phoneicon icons">
                                <label>Mobile Number<span style = "color:red">*</span></label>
                                <input type="tel" value="{{Auth::user()->phone_number ?? ""}}" name="phone_number" id="" placeholder="Phone Number *" class="form-control"  required/>
                            </div>
                        </div>
                        <input type="hidden" name="payment_amt" value="" />
                        <input type="hidden" name="TotalPrice" class="TotalPrice" value="" />
                        <input type="hidden" name="discountPrice" class="discountPrice" value="" />
                        <input type="hidden" name="is_check" class="is_check" value="" />
                        <input type="hidden" name="taxes" value="" /> 
                        <input type="hidden" name="meal_id" value="" />
                        <input type="hidden" id="PersonOne" value="{{$place->roomsData->first()->onepersonprice }}" />
                        <input type="hidden" id="PersonTwo" value="{{$place->roomsData->first()->twopersonprice }}" />
                        <input type="hidden" id="PersonThree" value="{{$place->roomsData->first()->threepersonprice }}" />
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="form-group messageicon icons">
                                <textarea placeholder="Message" class="form-control textareainput"></textarea>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label><input type="checkbox" name="" id="checkboxid" /> If Bookings for Other</label>
                                <div id="autoupdate" class="contentinner">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="form-group firsticon icons">
                                                <label>First Name</label>
                                                <input type="text" value="" name="" id="" placeholder="First Name *" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="form-group lasticon icons">
                                                <label>Last Name</label>
                                                <input type="text" value="" name="" id="" placeholder="Last Name *" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="form-group emailicon icons">
                                                <label>Email ID (optional)</label>
                                                <input type="email" value="" name="" id="" placeholder="Email ID" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6">
                                            <div class="form-group phoneicon icons">
                                                <label>Mobile Number</label>
                                                <input type="tel" value="" name="" id="" placeholder="Phone Number *" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payrow">
                        <div class="row">
                            <div class="col-6 col-sm-3 col-md-3">
                                <div class="form-group">
                                    <label>Pay Now</label>
                                    <input value="online" id="showButtons" type="radio" class="online_payment" name="payment_type"  />
                                </div>
                            </div>
                            <div class="col-6 col-sm-9 col-md-9">
                                <div class="form-group">
                                    <label style="font-size: 15px;">Pay at Hotel(20 % need to pay for confirmation)</label>
                                    <input type="radio" value="offline" id="hideButtons" class="online_payment" name="payment_type" /> 
                                </div>
                            </div>
                        </div>
                    </div>
                        @if($referl_money)

          <div class="row ">
                            <div class="col-12 col-sm-12 col-md-12">
                <table style="">
                    <!--<tr>-->
                    <!--    <th width="200px;"><i class="fas fa-wallet">&nbsp; My Wallet</i></th>-->
                    <!--    <td></td>-->
                    <!--</tr>-->
                    <tr>
                        <th ><i class=""style="font-style:initial"> Check Here Use Wallet Amount : {{$referl_money}}</i></th>
                    <input type = "hidden" name = "refer" id = "refer_mon" value = "{{$referl_money}}">
                        
                        <td colspan="2" >  <input id="check01" type="checkbox" name="payment_amt" class="" value=""></td>
                        <input type = "hidden" name = "pay_bef" = id = "pay_bef">
                    </tr>
                </table>
            </div>
            </div>
            @endif
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn contactbtn" onclick="gtag_report_conversion()" >Complete your Booking</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="{{\App\Models\Booking::TYPE_BOOKING_FORM}}">
                    <input type="hidden" name="place_id" value="{{$place->id}}">
                    <input type="hidden" name="date" value="">
                    <input type="hidden" name="number_of_room" value="">
                    <input type="hidden" name="numbber_of_adult" value="">
                    <input type="hidden" name="numbber_of_children" value="0">
                    <input type="hidden" name="booking_start" value="">  
                    <input type="hidden" name="booking_end" value="">
                </form>
            </div>
            <div class="col-12 col-sm-5 col-md-5">
                <div class="personalinformationimage">
                    <img src="https://nsnhotels.com/uploads/610bba514ff73_1628158545.jpg" class="hotel_img" alt="NSN Hotel Image"/>
                    <div class="bookingdetails text-center">
                        <div class="nsnhotelsname hotel_name"></div>
                        <ul>
                            <li>Date<span class="booking_date"></span></li>
                            <li>Guest<span class="number_person"></span></li>
                            <li>Room<span class="room_avail"></span></li>
<!--                            <li class="inrsymbols">Price<span class="payment_amt"></span></li>
                            <li class="inrsymbols">Taxes &amp; Fees<span class="Taxes"></span></li>-->
                            <li class="inrsymbols">Payable Amount : <span class="TotalPrice"></span></li>
                        </ul>
                    </div>
                </div>
            </div>
  
          
            
        </div>
    </div>
</div>


      @php
      
      if(isset($gallery)){
      $gallery = "";
      }
      
      else{
      $gallery = "";
      }
    
      @endphp
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Hotel",
    "name": "{{$place->PlaceTrans->name}}",
    "description": "{{ Str::limit($place->description, 120) }}",
    "address": {
        "@type": "PostalAddress",
        "addressCountry": "IN",
        "addressLocality": "{{$place->address}}",
        "addressRegion": "{{$place->address}}",
        "postalCode": "602000",
        "streetAddress": "Technikerstrasse 21"},
    "telephone": "+91 9958277997",
    "photo" :"{{getImageUrl($gallery)}}",
    "starRating": {
        "@type": "Rating",
        "ratingValue": "4.3"},
    "image" :"{{getImageUrl($gallery)}}",
     "priceRange": "₹1000"
}</script>
@stop
@push('scripts')

<script type="text/javascript">
$(".close-btn, .bg-overlay").click(function(){
  $(".custom-model-main").removeClass('model-open');
});
</script>

   <script type="text/javascript">
$(function(){
	var overlay = $('<div id="overlay"></div>');
	overlay.show();
	overlay.appendTo(document.body);
	$('.bokingpopup').show();
	$('.close').click(function(){
	$('.bokingpopup').hide();
	overlay.appendTo(document.body).remove();
	return false;
});
$('.x').click(function(){
	$('.bokingpopup').hide();
	overlay.appendTo(document.body).remove();
	return false;
	});
});
</script>

<script type="text/javascript">
$( '.gallery-items').find('.gallery-item:nth-child(4)' ).addClass( 'gallery-item-second' );

let rooms =  <?php echo json_encode($place->roomsData->toArray()) ?>;

const roomMaxAdultCreate    = (max) =>  {
  $('#numbber_of_adult').find('option').remove();
  for(i=1;i<=max;i++) {
      $('#numbber_of_adult').append(`<option value="${i}">${i}</option>`);
    }
    $('#numbber_of_adult').niceSelect('update');
}

$(document).on('change', '#room_type' ,function() {
    let selectedRoomId = $('#room_type').val();
    //$('.booking_type_div').hide();
    $('#booking_type').find('option').remove();
    if(selectedRoomId && selectedRoomId > 0) {
        let room = rooms.find((r) => r.id == selectedRoomId);
        if(room) {
            //$('.booking_type_div').show();
            $('#booking_type').append(`<option value="" >Select Booking Type</option>`);
            if(room.hourlyprice && room.hourlyprice > 0) {
                $('#booking_type').append(`<option value="hourlyprice" >3 Hours Price</option>`);
            }
            $('#booking_type').append(`<option value="night_price">Night Price</option>`);
        }
        roomMaxAdultCreate(room.adults);
    }
    $('#booking_type').niceSelect('update');
});

$(document).on('change', '#booking_type' ,function() {
  let selectedBookingType = $('#booking_type').val();
  calculateRoomPrice();
  $('input[name="bookdates"]').val('');
  if(selectedBookingType == 'hourlyprice') {
    $("#AdultsAllowed").val('2');
    $("#AdultsAllowed").attr('readonly','readonly');
    let selectedRoomId = $('#room_no').val();
    $('.room_no_div').hide();
    $('.room_no_div').show();
    $('#room_no').append(`<option value="1" selected>1</option>`);
    $('#room_no').niceSelect('update');
      roomMaxAdultCreate(2);
      $('input[name="bookdates"]').daterangepicker({
        autoUpdateInput: true,
        minDate:new Date(),
        singleDatePicker: true,
        autoApply: true,
        parentEl: $(".bookdate-container"),
        locale: {
            format: 'D MMMM, YYYY'
        }
      }, function(start,end) {
        $('#bookdates').val(start.format('D MMMM, YYYY'));
        calculateRoomPrice();
      });
      calculateRoomPrice();
  } else {
     $("#AdultsAllowed").removeAttr('readonly');
     var date = new Date();
      $('input[name="bookdates"]').daterangepicker({
        minDate:new Date(),
        autoUpdateInput: true,
        autoApply: true,
        parentEl: $(".bookdate-container"),
        startDate: moment(date),
        endDate: moment(date).add(1,'days'),
        locale: {
            format: 'D MMMM, YYYY'
        }
      }, function(start, end) {
        $('#bookdates').val(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
        calculateRoomPrice();
      });
       calculateRoomPrice();
    }
});

$(document).on('change', '#room_type,#bookdates,#numbber_of_adult' ,function() {
    calculateRoomPrice();
});

$("#AdultsAllowed").on("keypress click", function(){
    $('.validationMessage').hide();
   var grandTotal = $("#grand_total").val();
     let selectedRoomId = $('#room_no').val();
     let bookType = $('#booking_type').val();
     if(bookType == 'hourlyprice')
     {
      return false;
     }
     if(selectedRoomId == 0)
     {
      $('#AdultsAllowed').val(0);
      alert('Please Select Room ')
      return false;
     }
        calPeople = selectedRoomId * 3;
         totalPeo = calPeople + 1;
        var maxLength = calPeople;
        var limitPeo = $('#AdultsAllowed').val();
        if (totalPeo <= limitPeo) {
            $('#AdultsAllowed').val(calPeople);
            $('#errorshow').after("<span class='validationMessage' style='color:red;'> Maximum people "+calPeople+".</span>");
        }else{
             calculateRoomPrice();
           //  PeopleTotal = limitPeo / selectedRoomId;
           //   var PersonOne = parseFloat($('#PersonOne').val());
           //   var PersonTwo = parseFloat($('#PersonTwo').val());
           //   var PersonThree = parseFloat($('#PersonThree').val());
           //  if (PeopleTotal <= 1) {
           //     $("#grand_total").attr("value" ,parseFloat(PersonOne) * parseFloat(selectedRoomId));
           // }else if (PeopleTotal <= 2) {
           //    $("#grand_total").attr("value" , parseFloat(PersonTwo) * parseFloat(selectedRoomId));
           // } else {
           //  if(PersonThree !== null){
           //      TotalPrice = PersonTwo - PersonOne;
           //      $("#grand_total").attr("value" ,(PersonTwo + TotalPrice) * parseFloat(selectedRoomId));
           //     }else{
           //      $("#grand_total").attr("value" ,PersonThree *  parseFloat(selectedRoomId));
           //     }
           // }
 }
});
 $('#room_no').on('change', function() {
    let selectedRoomId = $('#room_no').val();
      var PersonOne = parseFloat($('#PersonOne').val());
      if(selectedRoomId > 0){
       calculateRoomPrice();
       }

});
  $('#meals').on('change', function() {
    
       calculateRoomPrice();

});

var CPPrice = parseInt($("#final_total").val());

$("#cprice").on('change', function(){
    let couponCode = $("#cprice").val();
    let letterNumber = /^[0-9a-zA-Z]+$/;
    if(couponCode === ""){
        calculateCouponValue(couponCode);
        return false;
    }else if (couponCode.length !== 6 ) {
        alert("please enter a valid coupon code!");
        return false;
    } 
    else if(!couponCode.match(letterNumber)){
        alert("Enter a valid coupon code !");
        return false;
    }else{
    calculateCouponValue(couponCode);
     return true;
    }
});


//calculate coupon price value
function calculateCouponValue(couponCode){
    var iniPrice = parseInt($("#final_total").val());
    
    if(couponCode === ""){
        var afterDisPrice =  iniPrice;
    }
    else{
        @php
    foreach($coupon as $cou){ @endphp
        var c = "{{$cou->coupon_name}}" ;
        var val = "{{$cou->coupon_value}}";
        var per = "{{$cou->coupon_percent}}";
        var cMin = "{{$cou->coupon_min}}";
        if(parseInt(iniPrice) >= parseInt(cMin)){
            if(c === couponCode && val != ""){
                var afterDisPrice  = iniPrice - parseInt(val);
                $("#grand_total").attr("value" , (afterDisPrice).toFixed(2));
                 $("#grand_totals").text((afterDisPrice).toFixed(2));
                alert("Discount Rs. " + val + ".00 has been applied !");
             return false;
             }
             if(c === couponCode && per != ""){
                var afterDisPrice  = iniPrice - parseInt(((parseInt(per)*iniPrice)/100));
                $("#grand_total").attr("value" , (afterDisPrice).toFixed(2));
                 $("#grand_totals").text((afterDisPrice).toFixed(2));
                alert(per + " % Discount has been applied !");
             return false;
             }
             
        }else{
            alert("Coupon cannot be apply !");
            return false;
        }
            
         @php
         }
     @endphp
    }
     
}

function calculateRoomPriceNightBase(bookdates, roomType,numbber_of_adult,room_no,bookType) {
    
      var limitPeo = $('#AdultsAllowed').val();
        var booking_type = $('#booking_type').val();
      let selectedRoomId = $('#room_no').val();
      let splitDate = bookdates.split("-");
      let start = new Date(splitDate[0]);
      let end = new Date(splitDate[1]);
      if(start == end){
          alert('Start Date and end date can not be same.');
      }
      let c = 24 * 60 * 60 * 1000;
      let diffDays = Math.round(Math.abs((start - end) / (c)));
      let calPrice = 0;
       PeopleTotal = limitPeo / selectedRoomId;
         var PersonOne = parseFloat($('#PersonOne').val());
         var PersonTwo = parseFloat($('#PersonTwo').val());
         var PersonThree = parseFloat($('#PersonThree').val());
      if(diffDays >= 1) {
          let room = rooms.find((r) => r.id == roomType);
          let room_price;
          if(bookType == 'night_price') {
          if(PeopleTotal <= 1) {
              room_price = room.onepersonprice;
          }
          if(PeopleTotal <= 2  && PeopleTotal > 1) {
              room_price = room.twopersonprice;
          }
          if(PeopleTotal > 2) {
            if(PersonThree == null || isNaN(PersonThree)){
                TotalPrice = PersonTwo - PersonOne;
                room_price = PersonTwo + TotalPrice;
            }
            else{
             room_price = room.threepersonprice;
            }
          }
           var meals_pricce = 0;
             var meals = $('#meals').val();
             if(meals){
                var meals_pricce =  parseFloat($('#'+meals).val());
             }
          var taxes = 0;
          calPrice =  (selectedRoomId * diffDays) * room_price;
        var to_cal_price =  calPrice * room_no + meals_pricce;
          }else if(booking_type == 'hourlyprice'){
            var meals_pricce = 0;
             var meals = $('#meals').val();
             if(meals){
                var meals_pricce =  parseFloat($('#'+meals).val());
             }
          var taxes = 0;
               room_price = room.hourlyprice;
               calPrice = room.hourlyprice;
               to_cal_price = room.hourlyprice;
          }
          // if(numbber_of_adult == 4) {
          //     room_price = room.fourpersonprice;
          // }
        @php foreach($tax as $tas){ @endphp
        var price_min = {{$tas->price_min}} 
        var price_max = {{$tas->price_max}}
            if(to_cal_price >= price_min && to_cal_price <=  price_max){
            taxes = {{$tas->percentage}}
         }
         @php
         }
         @endphp
      }
      var tax_cal = 0;
      if(taxes > 0){
           tax_cal =  taxes * (calPrice + meals_pricce)/100;
      }
       if(booking_type == 'hourlyprice'){
           var no_hour =  parseFloat($('#hourlyprice').val()); 
      $("#price").attr("value" , no_hour);
      $("#grand_total").attr("value" , (no_hour).toFixed(2));
      $("#grand_totals").text((no_hour).toFixed(2));
         $(".TotalPrice").text((no_hour).toFixed(2));
      $("#final_total").attr("value" , (no_hour).toFixed(2));
      $("#tax_area").text("Incl Tax Value Rs " + 0);
      
       }
       else{
            $("#price").attr("value" , calPrice);
      $("#grand_total").attr("value" , (calPrice + meals_pricce + tax_cal).toFixed(2));
      $("#grand_totals").text((calPrice + meals_pricce + tax_cal).toFixed(2));
      $("#final_total").attr("value" , (calPrice + meals_pricce + tax_cal).toFixed(2));
      $("#tax_area").text("Incl Tax Value Rs " + tax_cal);
       }
}

function calculateRoomPrice() {
    $("#grand_total").attr("value" , '');
    let roomType          = $('#room_type').val();
    let bookType          = $('#booking_type').val();
    let numbber_of_adult  = $('#AdultsAllowed').val();
    let bookdates         = $('#bookdates').val();
    let room_no          = $('#room_no').val();
      sessionStorage.setItem("guest",numbber_of_adult);
      sessionStorage.setItem("room",room_no);
    if(roomType && numbber_of_adult && bookdates) {
        let room = rooms.find((r) => r.id == roomType);
        if(room.hourlyprice && room.hourlyprice > 0) {
          if(bookType == 'hourlyprice') {
            //Calculate Hour Price :-
            $("#grand_total").attr("value" , room.hourlyprice);
             calculateRoomPriceNightBase(bookdates, roomType,numbber_of_adult,room_no,bookType);
          } else if(bookType == 'night_price') {
            //night price calculation
            calculateRoomPriceNightBase(bookdates, roomType,numbber_of_adult,room_no,bookType);
          }
        } else {
          //night price calculation
            calculateRoomPriceNightBase(bookdates, roomType,numbber_of_adult,room_no,bookType);
        }
    } else {
    }
}

const showBookingDetail = (event) => {
    event.preventDefault();
    let $form = $("form[name='bookRoomForm']");
    let formData = getFormData($form);
    let splitDate = formData.bookdates.split("-");
    let start = new Date(splitDate[0]);
    let end = new Date(splitDate[1]);
    let c = 24 * 60 * 60 * 1000;
    let diffDays = Math.round(Math.abs((start - end) / (c)));
    let selectedRoomId = $('#room_no').val();
    let calPeople = selectedRoomId * 3;
    let totalPeo = calPeople + 1;
    let limitPeo = $('#AdultsAllowed').val();
    if (!formData.room_type) {
        alert("Please select Room Type");
        return;
    } else if (!formData.booking_type) {
        alert("Please select Booking Type");
        return;
    } else if (diffDays == 0) {
        alert('Check In / Check Out date can not be same.');
        return;
    } else if (formData.numbber_of_adult == "0") {
        alert("Please enter number of adult");
        return;
    } else if (totalPeo <= limitPeo) {
           alert("Please add minimum adult "+calPeople);
        return;

    }else {
       
       
        //Make A ajax call to show Booking Details :-
        $.ajax({
            type: "GET",
            url: '<?=route('booking_payment_data')?>',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                
                $('.bookingPaymentFormDiv').find('form').hide();
                $('.bookingPaymentFormDiv').append('<i class="fas fa-redo fa-spin fa-4x"></i>')
            },
            success: function (response) {
                $(".custom-model-main").addClass('model-open');
                let model = $('.modalPopupbook');
                model.find('.hotel_name').html(response.hotel.name);
                model.find('.hotel_address').html(response.hotel.address);
                model.find('.booking_date').text(response.date_range_display);
                model.find('.number_person').text(response.adults);
                model.find('.room_avail').text(response.number_of_room);
                model.find('input[name=numbber_of_adult]').val(response.adults);
                model.find('input[name=date]').val(response.date_range_display);
                model.find('input[name=payment_amt]').val(response.payment_old);
                model.find('input[name=booking_start]').val(response.start_date);
                model.find('input[name=number_of_room]').val(response.number_of_room);
                model.find('input[name=booking_end]').val(response.end_date);
                model.find('input[name=taxes]').val(response.tax_cal);
                model.find('input[name=meal_id]').val(response.meal_id);
                model.find('.payment_amt').html(response.payment_old);
                model.find('.hotel_img').attr("src", response.hotel.thumb);
                // model.find('input[name=ccode]').val(response.coupon);
                 room_no = $('#room_no').val();
                 
                 $('.Taxes').text( response.tax_cal);
                 // $('.TotalPrice').val(response.payment_amount);
                   $('.is_check').val('0');
                   var p = $("#grand_total").val();
                   $('.TotalPrice').val(p);
                   $('.TotalPrice').text(p);
                   
                   $('.booking_date').text(response.date_range_display);
                   $('.room_avail').text(response.number_of_room);
                   $('.number_person').text(response.adults);
            },
            error: function (jqXHR) {
                var response = $.parseJSON(jqXHR.responseText);
                if (response.message) {
                    alert(response.message);
                }
            }
        }).always(function() {
            $('.bookingPaymentFormDiv').find('i').remove();
        });
    }
}
</script>
<script type="text/javascript">
function submitOrder(el){
    $(el).prop('disabled', true);
    if($('.online_payment').is(":checked")){
        $('#checkout-form').submit();
    }else{
        $(el).prop('disabled', false);
    }
}
</script>

<script src="{{asset('frontend/jss/page_place_detail.js')}}"></script>

<script type="text/javascript">

//     $("#showButtons").click(function(){
//       $('.showWallet').show();
//       });
//     $("#hideButtons").click(function(){
//   $("#check01").prop("checked", false);
//     total = parseFloat($('.payment_amt').text());
//       $('.TotalPrice').text(total);
//       $('.showWallet').hide();
//   });
//     var referal = {{$referl_money}};
     $("#check01").change(function() {
        if(this.checked) {
             total = parseFloat($('#refer_mon').val()) ;
             totalDis =  parseFloat($('#grand_total').val()) - total ;
            
              $('.discountPrice').val(totalDis);
                $('#pay_bef').val($('#grand_total').val());
              $('#pay_bef').val($('#grand_total').text());
              $('.TotalPrice').text(totalDis);
                  $("#grand_total").attr("value" ,totalDis);
              $('.is_check').val('1');
        }
      else
        {
            grand_totals
            total = parseFloat($('.payment_amt').text());
                          $('.TotalPrice').text($('#grand_totals').text());
                           $("#grand_total").attr("value" ,$('#grand_totals').text());
              $('.is_check').val('0');
        }
       
    });

        $(document).ready(function() {
           
            var url = '{{url()->current()}}';
           room =  sessionStorage.getItem("room");
                 if(room){
                    $('#room_no option[value=room]');
                    $('#room_no option[value="' + room + '"]').attr("selected", "selected");
                 }
           guest =  sessionStorage.getItem("guest");
           if(guest){
                $('#AdultsAllowed').val(guest);
           }
             sessionStorage.setItem('url',url);
              var date = new Date();
              var end_date = moment(date).add(1,'days');
              var start_date_db = $('#start_date').val();
              var start_end_db = $('#end_date').val();
              
              if(start_date_db == '' && start_end_db == ''){
           start_date_db =  sessionStorage.getItem("start_date");
           start_end_db =  sessionStorage.getItem("end_date");  
              }
              if(start_date_db  && start_end_db){
                 
                var date = new Date(start_date_db);
                var end_date = new Date(start_end_db);
              }
                
                             
                               
             
 @php 
// $paymentDate = date('Y-m-d');
if(isset($place['o_u_s_to'])   &&  isset($place['o_u_s_from'])){
 $paymentDate=date('Y-m-d', strtotime($place['o_u_s_to']));
  $paymentDate1=date('Y-m-d', strtotime($place['o_u_s_from']));
  if($start_date  &&  $end_date){
    
   $contractDateBegi ="<script>document.writeln(dateTo);</script>";
 $contractDateBegin =date('Y-m-d', strtotime($start_date));
 $contractDateEnd = date('Y-m-d',strtotime($end_date));
 }
 else{
 $contractDateBegi ="<script>document.writeln(dateTo);</script>";
  
  $contractDateBegin =date('Y-m-d', strtotime($contractDateBegi));
  $contractDateEnd = date('Y-m-d'); 
 
 }
    
if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)){
    $date_check = "yes";
}else{
    $date_check = "no";
}

if (($paymentDate1 >= $contractDateBegin) && ($paymentDate1 <= $contractDateEnd)){
    $date_checks = "yes";
}else{
    $date_checks = "no";
}
}
else{
    $date_check = "no"; 
    $date_checks = "no";
}


@endphp 

var date_check = "@php echo $date_check ; @endphp";
var date_checks = "@php echo $date_checks ; @endphp";
if(date_check == 'yes' || date_checks == 'yes'){
$('.nsnhotelsleftproperty').text('Room sold out');
$(".nsnhotelsleftproperty").css("background", 'red');
$(".nsnbooknowbt").text("Sold Out");
$(".nsnbooknowbt").attr("disabled", true);
}


              $('input[name="bookdates"]').daterangepicker({
                minDate:new Date(),
                autoUpdateInput: true,
                autoApply: true,
                parentEl: $(".bookdate-container"),
                startDate: moment(date),
                endDate: end_date,
                locale: {
                    format: 'D MMMM, YYYY'
                }
              },function(start, end) {
                $('#bookdates').val(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
                               calculateRoomPrice();
                                  sessionStorage.setItem("start_date",start.format('D MMMM, YYYY'));
                         sessionStorage.setItem("end_date",end.format('D MMMM, YYYY'));
                              $('#start_date').val(start.format('D MMMM, YYYY'));
                              
                              $('#end_date').val(end.format('D MMMM, YYYY'));
                              $('#date_form').trigger('submit');
                             
                              
              });
               calculateRoomPrice();
               
                let selectedRoomId = $('#room_type').val();
            $('.booking_type_div').hide();
            $('#booking_type').find('option').remove();
            if(selectedRoomId && selectedRoomId > 0) {
                let room = rooms.find((r) => r.id == selectedRoomId);
                if(room) {
                    $('.booking_type_div').show();
                    $('#booking_type').append(`<option value="" >Select Booking Type</option>`);
                    if(room.hourlyprice && room.hourlyprice > 0) {
                        $('#booking_type').append(`<option value="hourlyprice" >3 Hours Price</option>`);
                     }
                    $('#booking_type').append(`<option value="night_price" selected>Night Price</option>`);
                }

                roomMaxAdultCreate(room.adults);
            }
            $('#booking_type').niceSelect('update');
             $('#bookdates').change(function () {
             calculateRoomPrice();
            
        });
        });
        function cal(){
            calculateRoomPrice();
        }
        function gtag_report_conversion(url) {
  var callback = function () {
    if (typeof(url) != 'undefined') {
      window.location = url;
    }
      
  };
  gtag('event', 'conversion', {
      'send_to': 'AW-315826411/8aaXCLHh0o4DEOvBzJYB',
      'event_callback': callback
  });
  return false;
}
</script>
@endpush