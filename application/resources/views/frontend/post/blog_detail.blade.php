@push('style')

@endpush
@extends('frontend.layouts.master')
@section('main')
<style>

    .grey-blue-bg {
    background: #ECF6F8;
}
.post-article {
    margin-bottom: 30px;
    float: left;
    width: 100%;
    position: relative;
}
.post-article .list-single-main-media, .card-post .list-single-main-media {
    margin: 0;
}
.list-single-main-media {
    overflow: hidden;
    margin-bottom: 20px;
}
.fl-wrap {
    float: left;
    width: 100%;
    position: relative;
}
.single-slider-wrapper img, .inline-carousel img {
    width: 100%;
    height: auto;
}
article.post-article .list-single-main-item {
    margin-bottom: 20px;
}
article .list-single-main-item, article.post-article .list-single-main-item:last-child {
    margin-bottom: 0;
}
.list-single-main-item {
    padding: 30px 30px;
    background: rgb(255, 255, 255);
    margin-bottom: 20px;
    border: 1px solid #f2f2f2;
    border-radius: 1.2rem;
}
.list-single-main-item-title {
    margin: 0 0 25px 0;
    padding-bottom: 25px;
    border-bottom: 1px solid #eee;
}
.list-single-main-item-title h3 {
    color: #183c7d;
    text-align: left;
    font-size: 18px;
    font-weight: 600;
}
.list-single-main-item p {
    text-align: left;
    color: #878C9F;
}
.post-author {
    float: left;
    margin-right: 20px;
    margin-top: 10px;
}
.post-author img {
    width: 40px;
    height: 40px;
    border-radius: 100%;
    float: left;
    margin-right: 20px;
}
.post-author span {
    font-weight: 600;
    position: relative;
    top: 14px;
    color: #666;
    font-size: 12px;
}
.post-opt, .post-opt li {
    float: left;
}
.post-opt {
    padding-top: 24px;
}
ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
    display: inline-block;
}
.post-opt li {
    margin-right: 20px;
}
.post-opt, .post-opt li {
    float: left;
}
.post-opt li span, .post-opt li a {
    color: #999;
    font-weight: 500;
    font-size: 12px;
}
.list-single-main-item-title {
    margin: 0 0 25px 0;
    padding-bottom: 25px;
    border-bottom: 1px solid #eee;
}
.box-widget-content {
    float: left;
    width: 100%;
    position: relative;
    padding: 25px 30px 30px;
}
.box-widget {
    background: rgb(255, 255, 255);
    border-radius: 4px;
    border: 1px solid #eee;
    float: left;
    width: 100%;
}
.box-widget-content {
    float: left;
    width: 100%;
    position: relative;
    padding: 25px 30px 30px;
}
.box-widget-item-header {
    padding: 0 0 20px;
    margin: 0 0 25px;
    float: left;
    width: 100%;
    border-bottom: 1px solid #eee;
    position: relative;
}
.box-widget-item-header h3 {
    text-align: left;
    font-size: 16px;
    font-weight: 600;
    color: #183c7d;
}
.box-image-widget {
    float: left;
    width: 100%;
    position: relative;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
.box-image-widget-media {
    float: left;
    width: 35%;
}
.box-image-widget-media img {
    width: 100%;
    height: auto;
}
img{
    width: 100%!important;
}
</style>



	<section class="middle-padding grey-blue-bg py-5">
                        <div class=" container-fluid">
                            <div class="row">
                                <!--blog content -->
                                <div class="col-md-8">
                                    <!--post-container -->
                                    <div class="post-container ">
                                        <!-- article> -->
                                        <article class="post-article">

                                            <div class="list-single-main-item fl-wrap">
                                                <div class="list-single-main-media fl-wrap">
                                                <div class="single-slider-wrapper fl-wrap">
                                                     <img src="{{getImageUrl($post->thumb)}}" alt="{{$post->title}}">
                                                </div>
                                            </div>
                                                <div class="list-single-main-item-title fl-wrap pt-3">
                                                    <h3>{{$post->title}}</h3>
                                                </div>
                                                 {!! $post->content !!}

                                            </div>

                                        </article>
                                        <!-- article end -->
                                    </div>
                                    <!--post-container end -->
                                </div>
                                <!-- blog content end -->
                                <!--   sidebar  -->
                                <div class="col-md-4">
                                    <!--box-widget-wrap -->
                                    <div class="box-widget-wrap fl-wrap fixed-bar">
                                        <!--box-widget-wrap -->
                                    <div class="box-widget-wrap fl-wrap">
                                        <!--box-widget-item -->
                                        {{--
                                        <div class="box-widget-item fl-wrap">
                                            <div class="box-widget">
                                                <div class="box-widget-content">
                                                    <div class="box-widget-item-header">
                                                        <h3> Categories</h3>
                                                    </div>
                                                    <ul class="cat-item">
                                                        <li><a class="{{!isRoute('post_list_all')?: 'active'}}" href="{{route('post_list_all')}}" title="All">{{__('All')}}</a> <span>({{$post_total}})</span></li>
                                                         @foreach($categories as $cat)
                                                            <li><a class="{{isActive($cat_slug, $cat->slug)}}" href="{{route('post_list', $cat->slug)}}" title="{{$cat->name}}">{{$cat->name}}</a> <span>({{$cat->post_count}})</span></li>
                                                         @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>--}}
                                        <!--box-widget-item end -->

                                    </div>
                                    <!--box-widget-wrap end -->

                                        <!--box-widget-item -->
                                        <div class="box-widget-item fl-wrap">
                                            <div class="box-widget widget-posts">
                                                <div class="box-widget-content">
                                                    <div class="box-widget-item-header">
                                                        <h3>{{__('Related Articles')}}</h3>
                                                    </div>
                                                    @foreach($related_posts as $related_post)
                                                    <!--box-image-widget-->
                                                    <div class="box-image-widget">
                                                        <div class="box-image-widget-media mr-2">
                                                            <img src="{{getImageUrl($related_post->thumb)}}" alt="{{$related_post->title}}">
                                                        </div>
                                                        </a>
                                                        <div class="box-image-widget-details">
                                                            <a href="{{route('post_detail', [$related_post->slug, $related_post->id])}}" >
                                                            <h5>{{$related_post->title}}</h5></a>
                                                            <p></p>
                                                            <span class="widget-posts-date"><i class="fa fa-calendar"></i>   {{Carbon\Carbon::parse($post->created_at)->format('d M Y')}} </span>
                                                        </div>
                                                    </div>
                                                    <!--box-image-widget end -->
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!--box-widget-item end -->

                                    </div>
                                    <!--box-widget-wrap end -->
                                </div>
                                <!--   sidebar end  -->
                            </div>
                        </div>
                        <div class="limit-box fl-wrap"></div>
                    </section>

@stop
