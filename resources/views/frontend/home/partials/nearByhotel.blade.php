@php

        if (Cache::get('latlon')) {
            $latitude = Cache::get('latlon')['latitude'];
            $longitude =  Cache::get('latlon')['longitude'];
     $places = App\Models\Property::where('status', 1)
     ->with('ratings')
     ->select('properties.*')
     ->selectSub(function ($query) {
         $query->from('testimonials')
             ->selectRaw('AVG(rating)')
             ->whereColumn('properties.id', 'testimonials.property_id');
     }, 'avg_rating')
     ->selectSub(function($query) {
         $query->from('rooms')
             ->select('onepersonprice')
             ->whereColumn('properties.id', 'rooms.property_id')
             ->limit(1);
     }, 'onepersonprice')
     ->havingRaw('avg_rating IN (3,4, 5)')
     ->where('property_type_id',41)
        ->selectRaw("( 6371 * acos( cos( radians(?) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(?) ) + sin( radians(?) ) * sin( radians( latitude ) ) ) ) AS distance", [$latitude, $longitude, $latitude])
        ->having('distance', '<=', 20)
        ->orderBy('distance','asc')
        ->limit(4)
        ->get();
    }else{
  $places=[];
    }
@endphp
@if (count($places))

    <div class="container my-5  custom-bg-white">

        <div class="d-flex justify-content-between align-items-center mb-2 mb-2 p-3 p-md-0">
            <h2 class="custom-fw-800  bold text-dark custom-fs-20 custom-fw-600 mb-3 pt-4">NearBy Places</h2>
            <div><a href="/hotels-near-me"
                    class="btn custom-border-radius-20 custom-bg-primary custom-text-white custom-fw-800 custom-fs-14 hover-on-white">View
                    All ➡</a></div>
        </div>
        <div class="row mt-2 mt-md-0 px-md-3 pb-4  ">
            @foreach ($places as $place)
                <div class="col-md-3 col-lg-3 col-6 col-sm-6 mx-0 px-0">
                    @include('frontend.partials.card1', $place)
                </div>
            @endforeach
        </div>
</div>
@endif
