@extends('frontend.layouts.master')
@section('main')
<div class="midarea">

			<div class="pageindicator">
				<div class="container">
					<ul>
						<li><a href="">Home</a></li>
						<li><a href="" class="active">Contact us</a></li>
					</ul>
				</div>
			</div>
			<div class="contactinner">
				<div class="container">
					<div class="row">
						<div class="col-12 col-sm-4 col-md-4">
							<div class="contactleft">
								<div class="httext">Our Office</div>
								<div class=" ">
									<div class="mapview" style="position:sticky!important;max-width:100%">
										<ul>
											<li>Contact No: <span><a href="tel:+919958277997" class="active">(+91) 9958277997</a></span></li>
											<li>Mail: <span><a href="mailto:admin@nsnhotels.com">admin@nsnhotels.com</a></span></li>
											<li>Website: <span><a href="https://www.nsnhotels.com" target="_blank">www.nsnhotels.com</a></span></li>
										</ul>
									</div>
								</div>
								<img src="https://dev.qtechsoftware.com/wp-content/uploads/2020/12/contact-opt-1.jpg" alt="About Image" class="img-fluid" />
								<p>Nsnhotels provides online Hotel Bookings of hotels and resorts in India. Book budget, cheap and luxury hotels or resorts at cost effective prices. Now check latest offers on Online Hotel Booking at Nsnhotels.com</p>
							</div>
						</div>
						<div class="col-12 col-sm-8 col-md-8 contactright">
							<div class="httext">Get in touch with us</div>
							<form class="contactform" action="{{route('page_contact_send')}}" method="post">
							    @method('post')
                                @csrf
								<div class="form-group  ">
									<input type="text" value="" name="name" id="name" placeholder="Full Name *" class="form-control" required/>
								</div>
								<input type="hidden" value="2" name="type"  class="form-control" />

								<div class="form-group  ">
									<input type="email" value="" name="email" id="" placeholder="Email *" class="form-control"required />
								</div>
								<div class="form-group  ">
									<input type="tel" value="" name="phone" id="" placeholder="Phone Number *" class="form-control"required />
								</div>
								<div class="form-group  ">
									<textarea class="form-control textareainput" name="message" id="note" placeholder="Message" required></textarea>
								</div>
								<div class="form-group">
									<button type="submit" class="btn contactbtn" id="submit">Send Message</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
@stop
