@extends('frontend.layouts.master')
@section('main')

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 offset-md-3">
 <div class="card text-center">
    <div class="card-body">
        <h1 class="font-weight-bold">Thank You</h1>

    <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.mjs" type="module"></script>

    <div class="text-center">

    <dotlottie-player src="https://lottie.host/e3c01c88-be4a-4e83-aa9e-219a668c8c9c/Dd7Htm84Ih.json" background="transparent" speed="1" style="width: 150px; height: 150px;margin:auto" loop autoplay></dotlottie-player>
</div>

<p>
    Thank you for choosing NsnHotels.We received your booking information.Please carry any kind of Id proof  with you during check in.

   <div class="my-3">
    <a href="/" class="btn btn-success"><i class="fas fa-arrow-left"> </i> Home Page</a>
 &nbsp;
    <a href="{{route('recipt',['uuid'=>$uuid])}}"  class="btn btn-success">View Detail <i class="fas fa-arrow-right"></i></a>
   </div>
</p>
</div>
 </div>
        </div>
    </div>
</div>

@stop

