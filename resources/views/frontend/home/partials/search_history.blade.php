@php

    $searches=session()->get('search_history');
    $i=1;
@endphp
<div class="searchsliders mt-2 mt-md-5 mb-2 mt-md-0 mb-md-0">
<p class="text-left font-weight-bold   px-2 d-block d-md-none custom-text-white mb-2">Recent Search</p>
<p class="text-left font-weight-bold  d-none d-md-block  custom-text-white mb-2">Recent Search</p>


    @if (isset($searches)&&count($searches)>0)
        
    <div id="searchslider" class="owl-carousel">
        @foreach (array_reverse($searches) as  $search)
        @if (!Str::contains($search['url'], 'ajax')&&$i<=5)
            
@php
    $i++
@endphp
        <div class="nsn-search-history">
            <a href="{{$search['url']}}">
                <p class="d-flex justify-content-between align-items-center">
                    <span class="search-history-icon d-flex align-items-center"><i class="fas fa-gift"></i>&nbsp;
                        {{Str::limit($search['city_name'],15)}}</span>
                    <span class="text-secondary"><i class="fas fa-chevron-right"></i></span>
                </p>
                <p class="text-secondary d-none d-md-block">
                    {{Carbon\Carbon::parse($search['start_date'])->format('d M, Y')}} -  {{Carbon\Carbon::parse($search['end_date'])->format('d M, Y')}}
                </p>
                <p class="text-secondary font-weight-bold  d-none d-md-block">
                    {{$search['total_guest']}} Guests in {{$search['total_room']}} room
                </p>

            </a>

        </div>
 
        @endif

        @endforeach
    </div>
    @else  
    <p class=" font-weight-bold custom-text-white text-center">No any recent Search</p>
    
    @endif

</div>
