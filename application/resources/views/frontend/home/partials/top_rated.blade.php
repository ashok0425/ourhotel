<div class="mt-5">
	<div class="container my-4 my-md-0  custom-bg-white">
		<h2 class="custom-fw-800  bold text-dark custom-fs-20 custom-fw-600 mb-3 pt-4">Top Rated Hotels</h2>
		<div class="row mt-2 mt-md-0 px-md-3 pb-4  ">
			@foreach($trending_places as $place)
  <div class="col-md-3 col-lg-3 col-6 col-sm-6 mx-0 px-0">
			@include('frontend.partials.card1',$place)
  </div>
		   @endforeach
	   </div>
	</div>
</div>