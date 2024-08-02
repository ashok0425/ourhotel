<div class="container px-0 my-5">
    <div class="">
        @php
            $offer4=coupons()->skip(3)->take(1)->first();
        @endphp
        @if ($offer4)
            <div class="offer-wrapper">
               <a href="{{$offer4->link}}">
                <img lsrc="{{getImageUrl($offer4->thumbnail)}}" alt="NSN offer" class=" w-100" loading='lazy'>
               </a>
            </div>
        @endif
    </div>
</div>
