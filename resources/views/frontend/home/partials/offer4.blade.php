<div class="container">
    <div class="row">
        @php
            $offer2=DB::table('coupon')->skip(4)->take(1)->first();
            $offer3=DB::table('coupon')->skip(5)->take(1)->first();

        @endphp
       <div class="col-md-6">
        @if ($offer2)
        <div class="offer-wrapper mb-4">
           <a href="{{$offer2->link}}">
            <img lsrc="{{getImageUrl($offer2->thumb)}}" alt="NSN offer" class="custom-border-radius-20 w-100">
           </a>
        </div>
    @endif
       </div>
       <div class="col-md-6">
        @if ($offer3)
        <div class="offer-wrapper mb-4">
           <a href="{{$offer3->link}}">
            <img lsrc="{{getImageUrl($offer3->thumb)}}" alt="NSN offer" class="custom-border-radius-20 w-100">
           </a>
        </div>
    @endif
       </div>
    </div>
</div>
