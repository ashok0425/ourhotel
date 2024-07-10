@extends('frontend.layouts.master')

@section('main')
        @include('frontend.user.breadcrum', ['title' => 'Notifications'])
            <div class="container my-5">

                    <div class="nsnhotelsbookinginformation mb-5">
                        <div class="row">
                            <div class="col-12 col-sm-3 col-md-3">
                                @include('frontend.user.sidebar')
                            </div>
                            <div class="col-12 col-sm-9 col-md-9">
                               @forelse ($notifications as $item)
                               <div class="bg-white row mb-2 p-2">
                         <div class="mt-3 custom-fw-600 ">
                                               <span><i class="fas fa-bell"></i> {{Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i:s')}}</span>
                                                {!! $item->body !!}
                                            </div>
                            </div>

                               @empty
                               <div class="bg-white row p-2 my-2">
                                <div class=" custom-fw-600 ">
                                                     No notification yet
                                                   </div>
                                   </div>
                               @endforelse

                        </div>
                    </div>
                </div>



@stop

