<div class="container">
    <div class="">
        @php
            $offer1=DB::table('coupon')->first();
        @endphp
        @if ($offer1)
     <div class="mt-5 mt-md-0"></div>
            <div class="offer-wrapper my-4">
                
               <a href="{{$offer1->link}}">
                <img src="{{getImageUrl($offer1->thumb)}}" alt="NSN offer" class="custom-border-radius-20 w-100">
               </a>
            </div>
        @endif
    </div>
</div>