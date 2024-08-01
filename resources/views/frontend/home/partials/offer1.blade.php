<div class="container px-0 my-5">
    <div class="">
        @php
            $offer1=coupons()->first();
        @endphp
        @if ($offer1)
            <div class="offer-wrapper">
               <a href="{{$offer1->link}}">
                <img lsrc="{{getImageUrl($offer1->thumbnail)}}" alt="NSN offer" class=" w-100" loading="lazy">
               </a>
            </div>
        @endif
    </div>
</div>
