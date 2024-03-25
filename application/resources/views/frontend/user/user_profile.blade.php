@extends('frontend.layouts.master')
@section('main')

	<div class="nsnhotelsbookinginformation container my-5 ">
					<div class="row">
						<div class="col-12 col-sm-3 col-md-3 ">
							@include('frontend.user.sidebar')
						</div>
						<div class="col-md-9 bg-white pt-md-5 pt-0">
							<form action="{{route('user_profile_update')}}" method="POST" enctype="multipart/form-data">
								@method('PUT')
								@csrf
								<div class="row mt-md-5 mt-md-0">
									<div class="col-md-6">
										<div class="form-group">
											<input type="text" name="name" value="{{auth()->user()->name}}" class="form-control custom-border-radius-0" placeholder="Your Name" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input type="email" name="email" value="{{auth()->user()->email}}" id="" class="form-control custom-border-radius-0" placeholder="Your Email Address">
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<input type="text" disabled id="" class="form-control custom-border-radius-0" placeholder="Your Phone number" value="{{auth()->user()->phone_number}}" required>
										</div>
									</div>





									<div class="col-md-6">
										<div class="form-group">
											<input type="file" name="avatar" id="" class="form-control custom-border-radius-0" placeholder="No of Guest">
										</div>
									</div>



									<div class="col-12">
							<button class="custom-bg-secondary py-2 border-none boder-o outline-none  custom-text-white d-block w-100 text-center custom-fw-700">Submit</button>


									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
@stop
