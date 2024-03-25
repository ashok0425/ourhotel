@extends('frontend.layouts.master')
@section('main')

   <style type="text/css">

  div button{
  top: 500px;
  height: 30px;
  margin: 0 auto;
}

.btnreview {
    margin-left: 383px;
    margin-top: -8px;
    font-size: 16px;
    padding-top: 3px;
}

.modal{
    display: none;
    top: 0;
    min-width: 244px;
    width: 70%;
    height: 538px;
    margin: 0 auto;
    margin-top: 0px;
    margin-left: auto;
    position: absolute;
    z-index: 40001;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px #000;
    margin-top: -63px;
    margin-left: 9%;
    animation-name: fadeIn_Modal;
    animation-duration: 0.8s;

}

.header a {
   line-height: 32px;
   margin-left: 535px;
}


.content{
  width: 100%;
  height: 250px;
}


//rating


.wrapper {
  margin: 0 auto;
  max-width: 960px;
  width: 100%;
}

.master {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: start;
  -ms-flex-pack: start;
  justify-content: flex-start;
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  padding-top: 40px;
}

h1 {
  font-size: 20px;
  margin-bottom: 20px;
}

h2 {
  line-height: 160%;
  margin-bottom: 20px;
  text-align: center;
}

.rating-component {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  margin-bottom: 10px;
}

.rating-component .status-msg {
  margin-bottom: 10px;
  text-align: center;
}

.rating-component .status-msg strong {
  display: block;
  font-weight: bold;
  margin-bottom: 10px;
}

.rating-component .stars-box {
  -ms-flex-item-align: center;
  align-self: center;
  margin-bottom: 15px;
}

.rating-component .stars-box .star {
  color: #ccc;
  cursor: pointer;
}

.rating-component .stars-box .star.hover {
  color: #ff5a49;
}

.rating-component .stars-box .star.selected {
  color: #ff5a49;
}

.feedback-tags {
  min-height: 119px;
}

.feedback-tags .tags-container {
  display: none;
}

.feedback-tags .tags-container .question-tag {
  text-align: center;
  margin-bottom: 40px;
}

.feedback-tags .tags-box {
  display: -webkit-box;
  display: -ms-flexbox;
  text-align: center;
  display: flex;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
}

.feedback-tags .tags-container .make-compliment {
  padding-bottom: 20px;
}

.feedback-tags .tags-container .make-compliment .compliment-container {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  color: #000;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
}

.feedback-tags
  .tags-container
  .make-compliment
  .compliment-container
  .fa-smile-wink {
  color: #ff5a49;
  cursor: pointer;
  font-size: 40px;
  margin-top: 15px;
  -webkit-animation-name: compliment;
  animation-name: compliment;
  -webkit-animation-duration: 2s;
  animation-duration: 2s;
  -webkit-animation-iteration-count: 1;
  animation-iteration-count: 1;
}

.feedback-tags
  .tags-container
  .make-compliment
  .compliment-container
  .list-of-compliment {
  display: none;
  margin-top: 15px;
}

.feedback-tags .tag {
  border: 1px solid #ff5a49;
  border-radius: 5px;
  color: #ff5a49;
  cursor: pointer;
  margin-bottom: 10px;
  margin-left: 10px;
  padding: 10px;
}

.feedback-tags .tag.choosed {
  background-color: #ff5a49;
  color: #fff;
}

.list-of-compliment ul {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
  -ms-flex-direction: row;
  flex-direction: row;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
}

.list-of-compliment ul li {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  cursor: pointer;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  margin-bottom: 10px;
  margin-left: 20px;
  min-width: 90px;
}

.list-of-compliment ul li:first-child {
  margin-left: 0;
}

.list-of-compliment ul li .icon-compliment {
  -webkit-box-align: center;
  -ms-flex-align: center;
  align-items: center;
  border: 2px solid #ff5a49;
  border-radius: 50%;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  -webkit-box-pack: center;
  -ms-flex-pack: center;
  justify-content: center;
  height: 70px;
  margin-bottom: 15px;
  overflow: hidden;
  padding: 0 10px;
  -webkit-transition: 0.5s;
  transition: 0.5s;
  width: 70px;
}

.list-of-compliment ul li .icon-compliment i {
  color: #ff5a49;
  font-size: 30px;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.list-of-compliment ul li.actived .icon-compliment {
  background-color: #ff5a49;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.list-of-compliment ul li.actived .icon-compliment i {
  color: #fff;
  -webkit-transition: 0.5s;
  transition: 0.5s;
}

.button-box .done {
  background-color: #ff5a49;
  border: 1px solid #ff5a49;
  border-radius: 3px;
  color: #fff;
  cursor: pointer;
  display: none;
  min-width: 100px;
  padding: 10px;
}

.button-box .done:disabled,
.button-box .done[disabled] {
  border: 1px solid #ff9b95;
  background-color: #ff9b95;
  color: #fff;
  cursor: initial;
}

.submited-box {
  display: none;
  padding: 20px;
}

.submited-box .loader,
.submited-box .success-message {
  display: none;
}

.submited-box .loader {
  border: 5px solid transparent;
  border-top: 5px solid #4dc7b7;
  border-bottom: 5px solid #ff5a49;
  border-radius: 50%;
  width: 60px;
  height: 60px;
  -webkit-animation: spin 0.8s linear infinite;
  animation: spin 0.8s linear infinite;
}

@-webkit-keyframes compliment {
  1% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  25% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  50% {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
  }

  75% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  100% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@keyframes compliment {
  1% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  25% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  50% {
    -webkit-transform: rotate(30deg);
    transform: rotate(30deg);
  }

  75% {
    -webkit-transform: rotate(-30deg);
    transform: rotate(-30deg);
  }

  100% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
}

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

    </style>

<!-- Event snippet for Purchase conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-315826411/8Sq9CPjS9L8DEOvBzJYB',
      'value': 999.0,
      'currency': 'INR',
      'transaction_id': ''
  });
</script>

		<div class="midarea">
			<div class="breadcrumarea">
				<div class="breadcrumbbg">
					<div class="pageindicator">
						<div class="container">
							<ul>
								<li><a href="{{ route('home') }}">Home</a></li>
								<li><a href="" class="active">Booking</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="profilecontainer">
				<div class="container">
					<div class="profileinner">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="Upcoming-tab" data-toggle="tab" href="#Upcoming" role="tab" aria-controls="Upcoming" aria-selected="true">Upcoming</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="Cancelled-tab" data-toggle="tab" href="#Cancelled" role="tab" aria-controls="Cancelled" aria-selected="false">Cancelled</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="Completed-tab" data-toggle="tab" href="#Completed" role="tab" aria-controls="Completed" aria-selected="false">Completed</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="Upcoming" role="tabpanel" aria-labelledby="Upcoming-tab">
							    @if(isset($bookings))
					@foreach($bookings as $booking)
						 @if(count(array($booking->booking_start >= date('Y-m-d') && $booking->status == 2)) < 0){
								<div class="httext">Looks empty, you've no upcoming booking.</div>
								<p>When you book a trip, you will see your itinerary here.</p>

						@endif
				@endforeach
				@endif
				<div class="container text-center">
				@if(Auth::user()->photo_id == NULL)
				<p>Upload a photo of your id proof to access E-Checkin (Adhaar or Voter).</p>
				<form method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                <input type="file" class="form-control round10 shadow"  name="photo_id" accept="image/png, image/jpeg">
                </div>
                <input type="submit" value="Submit" class="btn btn-primary btn-block">
                </form>
				@else
				<p><i class="fa fa-check-circle"></i>&nbsp;&nbsp; You are eligible for e-checkin</p>
				@endif
				</div>

				<div class="nsnhotelsbookinginformation">
					<div class="row">
						<div class="col-12 col-sm-3 col-md-3">
							<div class="usercard text-center">
								<div class="userprofile">
									<img src="{{getUserAvatar(user()->avatar)}}" alt="User Profile" />
								</div>
								<p>Welcome</p>
								<div class="nsnhotelsname">{{Auth::user()->name}}</div>
								<ul class="row m-0 bottomdata">
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="">Bookings</a></div>
									</li>
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="">Reviews</a></div>
									</li>
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="{{ route('logout') }}">Logout</a></div>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-12 col-sm-9 col-md-9">

							<div class="travelbooking">

								<div class="httext text-left">Bookings


								</div>
									<div style = "color:green">Thank you for booking hotel with us! </div>

								<ul>
								    	@foreach($bookings as $booking)
								    	@if($booking->booking_start >= date('Y-m-d') && $booking->status == 2)
									<li class="row">
									<a href="{{ route('cancel_booking',['id' =>$booking->id ])}}"><button type="submit" class="btn bookingcancelbtn" id="bookingcancel" >Cancel Booking</button></a>
										<span class="col-12 col-sm-1 col-md-1">
											<div class="userprofile">
												<img src="{{getUserAvatar(user()->avatar)}}" alt="User Profile" />
											</div>
										</span>

										@php
										$date1 = new DateTime($booking->booking_start);
                                        $date2 = new DateTime($booking->booking_end);
										$numberOfNights= $date2->diff($date1)->format("%a");
										@endphp
										<span class="col-12 col-sm-11 col-md-11">
										    <div> <button id="open{{$booking->id}}" onclick="openReviewModal({{$booking->id}})" class="btn btn-primary btnreview">Rate Hotel</button><div>
                                            <div class="modal" id="b{{$booking->id}}">
                                              <div class="header">
                                                <a href="#" class="cancel{{$booking->id}}">X</a>
                                              </div>
                                              <div class="content">

                                   <div class="wrapper">
                                          <div class="master">
                                            <h1>Review And rating</h1>
                                            <h2>How was your experience about our product?</h2>
                                         <form class="review-form " method="post" action="{{ route('create_rating') }}">
                                            @csrf
                                            <div class="rating-component">
                                              <div class="status-msg">
                                                <label>
                                                <input  class="rating_msg" type="hidden" name="comment" value=""/>
                                            </label>
                                              </div>
                                               <input type="hidden" name="place_id" id="place_id{{$booking->id}}" value="" />
                                              <div class="stars-box">
                                                <i class="star fa fa-star" title="1 star" data-message="Poor" data-value="1"></i>
                                                <i class="star fa fa-star" title="2 stars" data-message="Too bad" data-value="2"></i>
                                                <i class="star fa fa-star" title="3 stars" data-message="Average quality" data-value="3"></i>
                                                <i class="star fa fa-star" title="4 stars" data-message="Nice" data-value="4"></i>
                                                <i class="star fa fa-star" title="5 stars" data-message="very good qality" data-value="5"></i>
                                              </div>
                                              <div class="starrate">
                                                <label>
                                                <input  class="ratevalue" type="hidden" name="score" value=""/>
                                            </label>
                                              </div>
                                            </div>

                                            <div class="feedback-tags">
                                              <div class="tags-container" data-tag-set="1">
                                                <div class="question-tag">
                                                  Why was your experience so bad?
                                                </div>
                                              </div>
                                              <div class="tags-container" data-tag-set="2">
                                                <div class="question-tag">
                                                  Why was your experience so bad?
                                                </div>

                                              </div>

                                              <div class="tags-container" data-tag-set="3">
                                                <div class="question-tag">
                                                  Why was your average rating experience ?
                                                </div>
                                              </div>
                                              <div class="tags-container" data-tag-set="4">
                                                <div class="question-tag">
                                                  Why was your experience good?
                                                </div>
                                              </div>

                                              <div class="tags-container" data-tag-set="5">
                                                <div class="make-compliment">
                                                  <div class="compliment-container">
                                                    Give a compliment
                                                    <i class="far fa-smile-wink"></i>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="tags-box">
                                                <input type="text" class="tag form-control" name="comment" id="inlineFormInputName" placeholder="please enter your review">

                                              </div>
                                            </div>
                                            <div class="button-box">
                                              <input type="submit" class=" done btn btn-warning" disabled="disabled" value="Add review" />
                                            </div>
                                        </form>
                                            <div class="submited-box">
                                              <div class="loader"></div>
                                              <div class="success-message">
                                                Thank you!
                                              </div>
                                            </div>
                                          </div>

                                        </div>

                                              </div>
                                              <div class="footer">

                                              </div>
                                            </div>

										<!--	<div class="bookingpersonname">{{ $booking->name}}</div>-->
											<ul class="bookingpersondetails">
												<li>Booking ID<span>NSN{{$booking->id}}</span></li>
												<li>Booking Date<span>{{ formatDate($booking->created_at, 'd/m/Y') }}</span></li>
												<li>Check IN/OUT Date<span>{{formatDate($booking->booking_start, 'd/m/Y')}}  - {{formatDate($booking->booking_end, 'd/m/Y')}}</span></li>
												<li>Hotel Name<span>{{ $booking['place']['name'] }}</span></li>
												<li> No. of Guests<span>{{$booking->numbber_of_adult}}</span></li>
												<li>No. of Room<span>{{$booking->number_of_room}} </span></li>
												<li>No. of Nights <span>{{ $numberOfNights }} </span></li>
												<li>Mail<span>{{ $booking->email }}</span></li>
												<li>Phone<span>{{$booking->phone_number}}</span></li>
												<li class="inrsymbols">Booking Amount<span>{{$booking->TotalPrice}}</span></li>

												@if($booking->payment_type =='offline')
												<li>Payment Mode<span>Pay at Hotel</span></li>
												@endif
												@if($booking->payment_type =='online')
												<li>Payment Mode<span>Online</span></li>
												@endif
											</ul>
										</span>
									</li>
									@endif
									@endforeach
								</ul>

							</div>

						</div>

					</div>
				</div>
        	</div>
				<div class="tab-pane fade" id="Cancelled" role="tabpanel" aria-labelledby="Cancelled-tab">
						@foreach($bookings as $booking)
							@if(count(array($booking->status == 0)) < 0){
					<div class="httext">Looks empty, you've no cancel booking.</div>
					<p>When you book a trip, you will see your itinerary here.</p>

			     	@endif
			     	@endforeach
					<div class="nsnhotelsbookinginformation">
					<div class="row">
						<div class="col-12 col-sm-3 col-md-3">
							<div class="usercard text-center">
								<div class="userprofile">
									<img src="{{getUserAvatar(user()->avatar)}}" alt="User Profile" />
								</div>
								<p>Welcome</p>
								<div class="nsnhotelsname">{{Auth::user()->name}}</div>
								<ul class="row m-0 bottomdata">
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="">Bookings</a></div>
									</li>
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="">Reviews</a></div>
									</li>
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="{{ route('logout') }}">Logout</a></div>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-12 col-sm-9 col-md-9">

							<div class="travelbooking">

								<div class="httext text-left">Bookings</div>

								<ul>
								    	@foreach($bookings as $booking)
								    	@if($booking->status == 0 )
									<li class="row">
										<button type="submit" class="btn bookingcancelbtn" id="bookingcancel" >Cancel Booking</button>
										<span class="col-12 col-sm-1 col-md-1">
											<div class="userprofile">
												<img src="{{getUserAvatar(user()->avatar)}}" alt="User Profile" />
											</div>
										</span>
								     	@php
										$date1 = new DateTime($booking->booking_start);
                                        $date2 = new DateTime($booking->booking_end);
										$numberOfNights= $date2->diff($date1)->format("%a");
										@endphp
										<span class="col-12 col-sm-11 col-md-11">
											<div class="bookingpersonname">{{ $booking->name}}</div>
											<ul class="bookingpersondetails">
												<li>Booking ID<span>NSN{{$booking->id}}</span></li>
												<li>Booking Date<span>{{ formatDate($booking->created_at, 'd/m/Y') }}</span></li>
									<li>Check IN/OUT Date<span>

									    @if($booking->booking_start){{formatDate($booking->booking_start, 'd/m/Y')}}  - {{formatDate($booking->booking_end, 'd/m/Y')}}
									    @endif
									    </span></li>
												<li>Hotel Name<span>
												    @if(isset($booking['place']['name']))
												    {{ $booking['place']['name'] }} @endif</span></li>
												<li> No. of Guests<span>{{$booking->numbber_of_adult}}</span></li>
												<li>No. of Room<span>{{$booking->number_of_room}} </span></li>
												<li>No. of Nights <span>{{ $numberOfNights }} </span></li>
												<li>Mail<span>{{ $booking->email }}</span></li>
												<li>Phone<span>{{$booking->phone_number}}</span></li>
												<li class="inrsymbols">Booking Amount<span>{{$booking->TotalPrice}}</span></li>

												@if($booking->payment_type =='offline')
												<li>Payment Mode<span>Pay at Hotel</span></li>
												@endif
												@if($booking->payment_type =='online')
												<li>Payment Mode<span>Online</span></li>
												@endif
											</ul>
										</span>
									</li>
									@endif
									@endforeach
								</ul>

							</div>

						</div>

					</div>
				</div>




							</div>
							<div class="tab-pane fade" id="Completed" role="tabpanel" aria-labelledby="Completed-tab">
				 @foreach($bookings as $booking)
				@if(count(array($booking->status == 1)) < 0){
					<div class="httext">Looks empty, you've no Completed booking.</div>
					<p>When you book a trip, you will see your itinerary here.</p>

			     	@endif
                 @endforeach
				<div class="nsnhotelsbookinginformation">
					<div class="row">
						<div class="col-12 col-sm-3 col-md-3">
							<div class="usercard text-center">
								<div class="userprofile">
									<img src="{{getUserAvatar(user()->avatar)}}" alt="User Profile" />
								</div>
								<p>Welcome</p>
								<div class="nsnhotelsname">{{Auth::user()->name}}</div>
								<ul class="row m-0 bottomdata">
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="">Bookings</a></div>
									</li>
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="">Reviews</a></div>
									</li>
									<li class="col-4 col-sm-4 col-md-4">
										<div class="bottomtext"><a href="{{ route('logout') }}">Logout</a></div>
									</li>
								</ul>
							</div>
						</div>

						<div class="col-12 col-sm-9 col-md-9">

							<div class="travelbooking">

								<div class="httext text-left">Bookings</div>
								Thank you for booking hotel with us

								<ul>
								@foreach($bookings as $booking)
								@if($booking->status == 1 )
									<li class="row">
										<button type="submit" class="btn bookingcancelbtn" id="bookingcancel">Cancel Booking</button>
										<span class="col-12 col-sm-1 col-md-1">
											<div class="userprofile">
												<img src="{{getUserAvatar(user()->avatar)}}" alt="User Profile" />
											</div>
										</span>
								    	@php
										$date1 = new DateTime($booking->booking_start);
                                        $date2 = new DateTime($booking->booking_end);
										$numberOfNights= $date2->diff($date1)->format("%a");
										@endphp
										<span class="col-12 col-sm-11 col-md-11">

										   <!-- rating model-->
										     <div> <button id="open{{$booking->id}}" onclick="openReviewModal({{$booking->id}})" class="btn btn-primary btnreview">Rate Hotel</button><div>
                                            <div class="modal" id="b{{$booking->id}}">
                                              <div class="header">
                                                <a href="#" class="cancel{{$booking->id}}">X</a>
                                              </div>
                                              <div class="content">

                                   <div class="wrapper">
                                          <div class="master">
                                            <h1>Review And rating</h1>
                                            <h2>How was your experience about our product?</h2>
                                         <form class="review-form " method="post" action="{{ route('create_rating') }}">
                                            @csrf
                                            <div class="rating-component">
                                              <div class="status-msg">
                                                <label>
                                                <input  class="rating_msg" type="hidden" name="comment" value=""/>
                                            </label>
                                              </div>
                                               <input type="hidden" name="place_id" id="place_id{{$booking->id}}" value="" />
                                              <div class="stars-box">
                                                <i class="star fa fa-star" title="1 star" data-message="Poor" data-value="1"></i>
                                                <i class="star fa fa-star" title="2 stars" data-message="Too bad" data-value="2"></i>
                                                <i class="star fa fa-star" title="3 stars" data-message="Average quality" data-value="3"></i>
                                                <i class="star fa fa-star" title="4 stars" data-message="Nice" data-value="4"></i>
                                                <i class="star fa fa-star" title="5 stars" data-message="very good qality" data-value="5"></i>
                                              </div>
                                              <div class="starrate">
                                                <label>
                                                <input  class="ratevalue" type="hidden" name="score" value=""/>
                                            </label>
                                              </div>
                                            </div>

                                            <div class="feedback-tags">
                                              <div class="tags-container" data-tag-set="1">
                                                <div class="question-tag">
                                                  Why was your experience so bad?
                                                </div>
                                              </div>
                                              <div class="tags-container" data-tag-set="2">
                                                <div class="question-tag">
                                                  Why was your experience so bad?
                                                </div>

                                              </div>

                                              <div class="tags-container" data-tag-set="3">
                                                <div class="question-tag">
                                                  Why was your average rating experience ?
                                                </div>
                                              </div>
                                              <div class="tags-container" data-tag-set="4">
                                                <div class="question-tag">
                                                  Why was your experience good?
                                                </div>
                                              </div>

                                              <div class="tags-container" data-tag-set="5">
                                                <div class="make-compliment">
                                                  <div class="compliment-container">
                                                    Give a compliment
                                                    <i class="far fa-smile-wink"></i>
                                                  </div>
                                                </div>
                                              </div>

                                              <div class="tags-box">
                                                <input type="text" class="tag form-control" name="comment" id="inlineFormInputName" placeholder="please enter your review">

                                              </div>
                                            </div>
                                            <div class="button-box">
                                              <input type="submit" class=" done btn btn-warning" disabled="disabled" value="Add review" />
                                            </div>
                                        </form>
                                            <div class="submited-box">
                                              <div class="loader"></div>
                                              <div class="success-message">
                                                Thank you!
                                              </div>
                                            </div>
                                          </div>

                                        </div>

                                              </div>
                                              <div class="footer">

                                              </div>
                                            </div>




										    <!-- end rating model-->


										<!--	<div class="bookingpersonname">{{ $booking->name}}</div>-->
											<ul class="bookingpersondetails">
												<li>Booking ID<span>NSN{{$booking->id}}</span></li>
												<li>Booking Date<span>{{ formatDate($booking->created_at, 'd/m/Y') }}</span></li>
												<li>Check IN/OUT Date<span>{{formatDate($booking->booking_start, 'd/m/Y')}}  - {{formatDate($booking->booking_end, 'd/m/Y')}}</span></li>
												<li>Hotel Name<span>@if(isset($booking['place']['name']))
												    {{ $booking['place']['name'] }} @endif</span></li>
												<li> No. of Guests<span>{{$booking->numbber_of_adult}}</span></li>
												<li>No. of Room<span>{{$booking->number_of_room}} </span></li>
												<li>No. of Nights <span>{{ $numberOfNights }} </span></li>
												<li>Mail<span>{{ $booking->email }}</span></li>
												<li>Phone<span>{{$booking->phone_number}}</span></li>
												<li class="inrsymbols">Booking Amount<span>{{$booking->TotalPrice}}</span></li>

												@if($booking->payment_type =='offline')
												<li>Payment Mode<span>Pay at Hotel</span></li>
												@endif
												@if($booking->payment_type =='online')
												<li>Payment Mode<span>Online</span></li>
												@endif
											</ul>
										</span>
									</li>
									@endif
								@endforeach
								</ul>

							</div>

						</div>

					</div>
				</div>


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@stop
@push('scripts')
<script>
window.addEventListener('load',function(){
  if(window.location.pathname=="/user/thanku")
  {
   var total_price= parseFloat(document.querySelector("#Upcoming > div.nsnhotelsbookinginformation > div > div.col-12.col-sm-9.col-md-9 > div > ul > li > span.col-12.col-sm-11.col-md-11 > div > div > ul > li.inrsymbols").innerText.replace(/[^0-9.]/g,'').trim());

   var order_id =  document.querySelector("#Upcoming > div.nsnhotelsbookinginformation > div > div.col-12.col-sm-9.col-md-9 > div > ul > li > span.col-12.col-sm-11.col-md-11 > div > div > ul").innerText.split('\n')[1];

    gtag('event', 'conversion', {
        'send_to': 'AW-315826411/eQ9QCKTkrtADEOvBzJYB',
        'value': total_price,
        'currency': 'INR',
        'transaction_id': order_id
    });
   }
 });
</script>
<script type="text/javascript">

function openReviewModal(id){
    $("#place_id"+id).val(id);
    $("#b"+id).css("display","block");
    $(".cancel"+id).click(function(){
         $("#b"+id).fadeOut();
    });
}
 //review

$(".rating-component .star").on("mouseover", function () {
  var onStar = parseInt($(this).data("value"), 10); //
  $(this).parent().children("i.star").each(function (e) {
    if (e < onStar) {
      $(this).addClass("hover");
    } else {
      $(this).removeClass("hover");
    }
  });
}).on("mouseout", function () {
  $(this).parent().children("i.star").each(function (e) {
    $(this).removeClass("hover");
  });
});

$(".rating-component .stars-box .star").on("click", function () {
  var onStar = parseInt($(this).data("value"), 10);
  var stars = $(this).parent().children("i.star");
  var ratingMessage = $(this).data("message");

  var msg = "";
  if (onStar > 1) {
    msg = onStar;
  } else {
    msg = onStar;
  }
  $('.rating-component .starrate .ratevalue').val(msg);



  $(".fa-smile-wink").show();

  $(".button-box .done").show();

  if (onStar === 5) {
    $(".button-box .done").removeAttr("disabled");
  } else {
    $(".button-box .done").attr("disabled", "true");
  }

  for (i = 0; i < stars.length; i++) {
    $(stars[i]).removeClass("selected");
  }

  for (i = 0; i < onStar; i++) {
    $(stars[i]).addClass("selected");
  }

  $(".status-msg .rating_msg").val(ratingMessage);
  $(".status-msg").html(ratingMessage);
  $("[data-tag-set]").hide();
  $("[data-tag-set=" + onStar + "]").show();
});

$(".feedback-tags  ").on("click", function () {
  var choosedTagsLength = $(this).parent("div.tags-box").find("input").length;
  choosedTagsLength = choosedTagsLength + 1;

  if ($(this).hasClass("choosed")) {
    $(this).removeClass("choosed");
    choosedTagsLength = choosedTagsLength - 2;
  } else {
    $(this).addClass("choosed");
    $(".button-box .done").removeAttr("disabled");
  }

  console.log(choosedTagsLength);

  if (choosedTagsLength <= 0) {
    $(".button-box .done").attr("enabled", "false");
  }
});



$(".compliment-container .fa-smile-wink").on("click", function () {
  $(this).fadeOut("slow", function () {
    $(".list-of-compliment").fadeIn();
  });
});



$(".done").on("click", function () {
  $(".rating-component").hide();
  $(".feedback-tags").hide();
  $(".button-box").hide();
  $(".submited-box").show();
  $(".submited-box .loader").show();

  setTimeout(function () {
    $(".submited-box .loader").hide();
    $(".submited-box .success-message").show();
  }, 1500);
});


</script>
@endpush


