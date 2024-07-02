@extends('frontend.layouts.master')
@section('main')
        <div class="midarea">
			<div class="breadcrumarea">
				<img src="{{getImageUrl($post->thumb)}}" class="img-fluid" alt="{{$post->title}}" />
				<div class="breadcrumareacontent">
					<p><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span></p>
					<h1>{{$post->title}}</h1>
				</div>
			</div>
			<div class="pageindicator">
				<div class="container">
					<ul>
						<li><a href="">Home</a></li>
						<li><a href="" class="active">{{$post->title}}</a></li>
					</ul>
				</div>
			</div>
			{!! $post->content !!}

		</div>
@stop
