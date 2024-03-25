

@php
    use App\Models\Post;
    $posts = Post::query()
            ->with('categories')
            ->with('user')
            ->where('type','blog')
            ->where('status', 1)->limit(4)->orderBy('id','desc')->get();
@endphp
	<div class="blogsslider d-none d-md-block mt-5 mb-0 container">
		<div class="container">
		<h2 class="custom-fw-800  bold text-dark custom-fs-20 custom-fw-600 mb-3 pt-4">Recent Blog</h2>
			
			<div  class="row">
				@foreach($posts as $post)
				<div class="col-md-3 col-lg-3 col-6 col-sm-6">
					<div class="nsnrecentstoriesbox">
						<a href="{{route('post_detail', [$post->slug, $post->id])}}">
						<img src="{{getImageUrl($post->thumb)}}" class="img-fluid" alt="{{$post->title}}"  />
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
<br>