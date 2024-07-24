<div class="container">
    <div class="row">
        @php
            $offer5=DB::table('coupon')->skip(4)->take(1)->first();
            $offer6=DB::table('coupon')->skip(5)->take(1)->first();

        @endphp
       <div class="col-md-6">
        @if ($offer5)
        <div class="offer-wrapper mb-4">
           <a href="{{$offer5->link}}">
            <img lsrc="{{getImageUrl($offer5->thumb)}}" alt="NSN offer" class="custom-border-radius-20 w-100">
           </a>
        </div>
    @endif
       </div>
       <div class="col-md-6">
        @if ($offer6)
        <div class="offer-wrapper mb-4">
           <a href="{{$offer6->link}}">
            <img lsrc="{{getImageUrl($offer6->thumb)}}" alt="NSN offer" class="custom-border-radius-20 w-100">
           </a>
        </div>
    @endif
       </div>
    </div>
</div>
