<div class="container">
    <div class="">
        @php
            $offer1=DB::table('coupon')->skip(3)->take(1)->first();
        @endphp
        @if ($offer1)
            <div class="offer-wrapper mt-4 mb-0">
               <a href="{{$offer1->link}}">
                <img src="{{getImageUrl($offer1->thumb)}}" alt="NSN offer" class="custom-border-radius-20 w-100">
               </a>
            </div>
        @endif
    </div>
</div>