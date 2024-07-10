@extends('frontend.layouts.master')
@php
$blog_title_bg = "style='background-image:url(/assets/images/img-bg-blog.png)'";
@endphp
@section('main')
@include('frontend.user.breadcrum', ['title' => 'Our Blogs'])

<div class="midarea mt-3">

	<div class="blogsslider">
		<div class="container">
			<div id="" class="row">
				@foreach($posts as $post)
				<div class="col-md-3 my-1">
				<div class="nsnrecentstoriesbox">
				<a href="{{route('post_detail', [$post->slug, $post->id])}}">

					<img src="{{getImageUrl($post->thumbnail)}}" class="img-fluid lazy" alt="{{$post->title}}" loading='lazy' />
				</a>
					<div class="nsnrecentstoriesboxcontent">
						<div class="nsndatestamp">{{ date('M j, Y', strtotime($post->created_at)) }}</div>

				<a href="{{route('post_detail', [$post->slug, $post->id])}}">

						<h2 class="custom-fw-700 custom-text-white custom-fs-20">{{$post->title}}</h2>

				</a>

					</div>
			</div>
		</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
<div class="d-flex mt-3 mb-5 justify-content-center w-100">
	{{$posts->links()}}
</div>
@stop
