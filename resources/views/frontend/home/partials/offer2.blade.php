<div class="container px-0 my-5">
    <div class="row">
        @php
            $offer2=coupons()->skip(1)->take(1)->first();
            $offer3=coupons()->skip(2)->take(1)->first();
        @endphp
       <div class="col-md-6 mt-4 mt-md-0 mb-0">
        @if ($offer2)
        <div class="offer-wrapper">
           <a href="{{$offer2->link}}">
            <img lsrc="{{getImageUrl($offer2->thumbnail)}}" alt="NSN offer" class=" w-100" loading="lazy">
           </a>
        </div>
    @endif
       </div>
       <div class="col-md-6 mt-4 mt-md-0 mb-0">
        @if ($offer3)
        <div class="offer-wrapper">
           <a href="{{$offer3->link}}">
            <img lsrc="{{getImageUrl($offer3->thumbnail)}}" alt="NSN offer" class="custom-border-radius-20 w-100">
           </a>
        </div>
    @endif
       </div>
    </div>
</div>
