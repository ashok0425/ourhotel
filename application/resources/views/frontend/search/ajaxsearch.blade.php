
					<div class="nsnhotelssearchdata">
								@if(count($placess) > 0)
						@foreach($placess as $place)
@include('frontend.partials.ajaxsearchcard',['place'=>$place])

							@endforeach  
							@else 
							<div class="text-center custom-fw-700 custom-fs-18">No Hotels Found</div>  
						@endif
				</div>
			
				