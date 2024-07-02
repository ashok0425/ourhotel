@php
    $place = DB::table('properties')->where('id', $id)->first();
    $data = [
        'lat' => $place->latitude,
        'long' => $place->longitude,
    ];
@endphp
@include('frontend.place.getlocation', $data)
@php
    $rating = DB::table('testimonials')
        ->where('property_id', $id)
        ->join('users', 'users.id', 'testimonials.user_id')
        ->select('testimonials.*', 'users.name', 'users.profile_photo_path as avatar', 'users.id as uid')
        ->orderBy('testimonials.id', 'desc')
        ->count();
    $avg = DB::table('testimonials')->where('property_id', $id)->avg('rating');

    $avg1 = DB::table('testimonials')->where('property_id', $id)->where('rating', 1)->avg('rating');
    $avg2 = DB::table('testimonials')->where('property_id', $id)->where('rating', 2)->avg('rating');
    $avg3 = DB::table('testimonials')->where('property_id', $id)->where('rating', 3)->avg('rating');
    $avg4 = DB::table('testimonials')->where('property_id', $id)->where('rating', 4)->avg('rating');
    $avg5 = DB::table('testimonials')->where('property_id', $id)->where('rating', 5)->avg('rating');

    $ratings = DB::table('testimonials')
        ->where('property_id', $id)
        ->join('users', 'users.id', 'testimonials.user_id')
        ->select('testimonials.*', 'users.name', 'users.profile_photo_path as avatar', 'users.id as uid')
        ->where('testimonials.feedback', '!=', null)
        ->orderBy('testimonials.id', 'desc')
        ->get();

@endphp
<h2 class="custom-fw-600 mb-3 mt-5 font-weight-bold">Hotel Review</h2>

<div class="mt-1">
    <div class="border">
        <div class="row ">
            <div class="col-md-12">
                <div class="row">
                    {{-- Average rating  --}}
                    <div class="col-md-5 border-right">
                        <div class="p-md-4 p-2">
                            <div class="custom-fw-900">
                                <div
                                    class="fas fa-star fa-3x @if ($avg >= 4) custom-text-success
                                @else custom-text-orange @endif">
                                </div>
                            </div>
                            <div class="custom-fw-500 mt-2"><span
                                    class="
      px-2
      @if ($avg >= 4) custom-bg-success
    @else
    custom-bg-orange @endif mt-2  ">{{ number_format($avg, 1) }}/5</span>
                                Based on {{ $rating }} ratings</div>
                        </div>
                    </div>

                    {{-- rating progress bar  --}}
                    <div class="col-md-7">
<div class="p-md-4 p-2">

    <div class="row">
        <div class="col-3 px-0 mx-0">
            5 Stars
        </div>
        <div class="col-8 px-0 mx-0 pt-1">
            <div class="progress ">
                <div class="progress-bar custom-bg-orange  " role="progressbar"
                    style="width: {{ $avg5 }}%" aria-valuenow="{{ $avg5 }}"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3 px-0 mx-0">
            4 Stars
        </div>
        <div class="col-8 px-0 mx-0 pt-1">
            <div class="progress ">
                <div class="progress-bar custom-bg-orange  " role="progressbar"
                    style="width: {{ $avg4 }}%" aria-valuenow="{{ $avg4 }}"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-3 px-0 mx-0">
            3 Stars
        </div>
        <div class="col-8 px-0 mx-0 pt-1">
            <div class="progress ">
                <div class="progress-bar custom-bg-orange  " role="progressbar"
                    style="width: {{ $avg3 }}%" aria-valuenow="{{ $avg3 }}"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-3 px-0 mx-0">
            2 Stars
        </div>
        <div class="col-8 px-0 mx-0 pt-1">
            <div class="progress ">
                <div class="progress-bar custom-bg-orange  " role="progressbar"
                    style="width: {{ $avg2 }}%" aria-valuenow="{{ $avg2 }}"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3 px-0 mx-0">
            1 Stars
        </div>
        <div class="col-8 px-0 mx-0 pt-1">
            <div class="progress ">
                <div class="progress-bar custom-bg-orange  " role="progressbar"
                    style="width: {{ $avg1 }}%" aria-valuenow="{{ $avg1 }}"
                    aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
</div>

                    </div>
                </div>
            </div>



        </div>
        {{-- rate and write review end --}}

    </div>


    <div class=" mt-4">

            @foreach ($ratings as $item)
                @if ($item->uid != 8)
                <div class="border-bottom py-2">
                    <div class="row align-items-center">
                     <div class="col-3 col-md-1">
                        <img src="{{ asset('frontend/user.png') }} " alt="{{ $item->name }}"
                                        class="img-fluid rounded-circle" width="60" height="60">

                     </div>
                     <div class="col-9 col-md-11 mx-0 px-0">
                       <strong> {{ $item->name }}</strong>  <span class="custom-fw-600 custom-fs-14">&nbsp; <i class="fas -fa-calendar"></i>{{  carbon\carbon::parse($item->created_at)->format('d M,Y') }}</span>
                       <div>
                        @for ($i = 0; $i < $item->rating; $i++)
                        <span class=" custom-text-orange custom-fs-14">
                         <i class="fas fa-star"></i>
                         </span>
                      @endfor
                      @for ($i = 0; $i < 5-$item->rating; $i++)
                        <span class="custom-fs-14">
                         <i class="far fa-star"></i>
                         </span>

                      @endfor
                       </div>
                     </div>
                    </div>
                    <div>
                        <div class="mt-3 custom-fw-600 custom-fs-14">
                            {!! $item->feedback !!}

                        </div>
                    </div>
                    </div>
                @endif
            @endforeach
    </div>
</div>

