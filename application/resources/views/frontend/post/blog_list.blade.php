@extends('frontend.layouts.master')
@php
$blog_title_bg = "style='background-image:url(/assets/images/img-bg-blog.png)'";
@endphp
@section('main')

<div class="midarea">
	<div class="breadcrumarea">
		<div class="breadcrumareacontent">
			<p><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span><span class="mdi mdi-star"></span></p>
			<h1>Blogs</h1>
			<p class="shortdescription">Browse the Latest Articles from our Blog.</p>
		</div>
	</div>
	<div class="pageindicator">
		<div class="container">
			<ul>
				<li><a href="">Home</a></li>
				<li><a href="" class="active">Blogs</a></li>
			</ul>
		</div>
	</div>
	<div class="blogsslider">
		<div class="container">
			<div id="" class="row">
				@foreach($posts as $post)
				<div class="col-md-3 my-1">
				<div class="nsnrecentstoriesbox">
				<a href="{{route('post_detail', [$post->slug, $post->id])}}">

					<img data-src="{{getImageUrl($post->thumb)}}" class="img-fluid lazy" alt="{{$post->title}}"  />
				</a>
					<div class="nsnrecentstoriesboxcontent">
						<div class="nsndatestamp">{{ date('M j, Y', strtotime($post->created_at)) }}</div>
						<ul>
						@foreach($post['categories'] as $cat)
						<li><a href="{{route('post_list', $cat->slug)}}" title="{{$cat->name}}"><i class="fa fa-tags"></i> {{$cat->name}}</a></li>
						@endforeach
						</ul>
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
<div class="pagination">
	{{$posts->render('frontend.common.pagination')}}
</div>
@stop
