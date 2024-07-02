@extends('frontend.layouts.master')

@section('main')
        @include('frontend.user.breadcrum', ['title' => 'Reviews'])
            <div class="container my-5">

                    <div class="nsnhotelsbookinginformation">
                        <div class="row">
                            <div class="col-12 col-sm-3 col-md-3">
                                @include('frontend.user.sidebar')
                            </div>
                            <div class="col-12 col-sm-9 col-md-9">
                               @foreach ($reviews as $item)
                               <div class="bg-white row mb-2 p-2">
                                 <div class="col-12">
                                    <div class="py-2">
                                        <div class="row align-items-center">
                                         <div class="col-3 col-md-1">
                                            <img src="{{ asset('frontend/user.png') }} " alt="{{ $item->user->name }}"
                                                            class="img-fluid rounded-circle" width="60" height="60">

                                         </div>
                                         <div class="col-6 col-md-9 mx-0 px-0">
                                           <strong> {{ $item->user->name }}</strong>  <span class="custom-fw-600 custom-fs-14">&nbsp; <i class="fas -fa-calendar"></i>{{  carbon\carbon::parse($item->created_at)->format('d M,Y') }}</span>
                                           <div>
                                            <div>
                                                <a href="{{$item->property?route('place_detail',['slug'=>$item->property->slug]) :''}}">{{$item->property->name??''}}</a>
                                            </div>
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
                                         {{-- <div class="col-3 col-md-2">
                                           <a href="" class="btn btn-primary"> <i class="fas fa-edit"></i></a>
                                           <a href="" class="btn btn-danger"> <i class="fas fa-trash"></i></a>

                                         </div> --}}
                                        </div>
                                        <div>
                                            <div class="mt-3 custom-fw-600 custom-fs-14">
                                                {!! $item->feedback !!}
                                            </div>
                                        </div>
                                        </div>
                                 </div>
                               </div>

                               @endforeach
                            </div>

                        </div>
                    </div>
                </div>



@stop

