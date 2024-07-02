

@php
    $posts =  App\Models\Blog::query()
            ->where('status', 1)->limit(4)->where('id','>',68)->latest()->get();
@endphp
	<div class="blogsslider  mt-5 mb-0 container">
		<div class="container">
            <div class="card shadow-sm border-0">
                <div class="card-body">

		<h2 class="custom-fw-800  bold text-dark custom-fs-20 custom-fw-600 mb-3">Recent Blog</h2>

			<div  class="row">
				@foreach($posts as $post)
				<div class="col-md-3 col-lg-3 col-6 col-sm-6">
					<div class="nsnrecentstoriesbox">
						<a href="{{route('post_detail', [$post->slug, $post->id])}}">
						<img src="{{getImageUrl($post->thumbnail)}}" class="img-fluid" alt="{{$post->title}}" loading="lazy" />
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
	</div>
<br>
