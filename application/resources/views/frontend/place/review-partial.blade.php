@php
$place=DB::table('places')->where('id',$id)->first();
$data=[
  'lat'=>$place->lng,
  'long'=>$place->lat,

];
@endphp
@include('frontend.place.getlocation',$data)
  @php
  $rating=DB::table('hotel_reviews')->where('product_id',$id)->join('users','users.id','hotel_reviews.user_id')->select('hotel_reviews.*','users.name','users.avatar','users.id as uid')->orderBy('hotel_reviews.id','desc')->get();
$avg_1=DB::table('hotel_reviews')->where('product_id',$id)->avg('rating');

 $avg=$avg_1;
$avg1=DB::table('hotel_reviews')->where('product_id',$id)->where('rating',1)->avg('rating');
$avg2=DB::table('hotel_reviews')->where('product_id',$id)->where('rating',2)->avg('rating');
$avg3=DB::table('hotel_reviews')->where('product_id',$id)->where('rating',3)->avg('rating');
$avg4=DB::table('hotel_reviews')->where('product_id',$id)->where('rating',4)->avg('rating');
$avg5=DB::table('hotel_reviews')->where('product_id',$id)->where('rating',5)->avg('rating');

$ratings=DB::table('hotel_reviews')->where('product_id',$id)->join('users','users.id','hotel_reviews.user_id')->select('hotel_reviews.*','users.name','users.avatar','users.id as uid')->where('hotel_reviews.feedback','!=',null)->orderBy('hotel_reviews.id','desc')->get();

@endphp
<div class="container border mt-1">
<div class="px-3">
<div class="row ">
<div class="col-md-6">
  <h4 class="custom-fw-700 pb-0 mb-0 font-weight-bold">Hotel Review</h4>
<br>
<div class="row">
{{-- Average rating  --}}
<div class="col-md-5 ">
<div class="  
custom-fw-900 py-3

"><div class="fas fa-star fa-3x

@if ($avg>=4)
custom-text-success
@else  
custom-text-orange
@endif


"></div></div>
<div class="custom-fw-500"><span class="
  px-2
  @if ($avg>=4)
  custom-bg-success
@else  
custom-bg-orange
@endif
  
  
  
  ">{{ number_format($avg,1) }}/5</span> Based on {{count($rating) }} ratings</div>
</div>

{{-- rating progress bar  --}}
<div class="col-md-7">

<div class="row">
<div class="col-3 px-0 mx-0">
5 Stars
</div>
<div class="col-8 px-0 mx-0 pt-1">
<div class="progress ">
  <div class="progress-bar custom-bg-orange  " role="progressbar" style="width: {{ $avg5 }}%" aria-valuenow="{{ $avg5 }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
</div>

<div class="row">
<div class="col-3 px-0 mx-0">
4 Stars
</div>
<div class="col-8 px-0 mx-0 pt-1">
<div class="progress ">
 <div class="progress-bar custom-bg-orange  " role="progressbar" style="width: {{ $avg4 }}%" aria-valuenow="{{ $avg4 }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>

</div>
</div>

<div class="row">
<div class="col-3 px-0 mx-0">
3 Stars
</div>
<div class="col-8 px-0 mx-0 pt-1">
<div class="progress ">
<div class="progress-bar custom-bg-orange  " role="progressbar" style="width: {{ $avg3 }}%" aria-valuenow="{{ $avg3 }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>

</div>
</div>

<div class="row">
<div class="col-3 px-0 mx-0">
2 Stars
</div>
<div class="col-8 px-0 mx-0 pt-1">
<div class="progress ">
<div class="progress-bar custom-bg-orange  " role="progressbar" style="width: {{ $avg2 }}%" aria-valuenow="{{ $avg2 }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
</div>

<div class="row">
<div class="col-3 px-0 mx-0">
1 Stars
</div>
<div class="col-8 px-0 mx-0 pt-1">
<div class="progress ">
<div class="progress-bar custom-bg-orange  " role="progressbar" style="width: {{ $avg1 }}%" aria-valuenow="{{ $avg1 }}" aria-valuemin="0" aria-valuemax="100"></div>
</div>
</div>
</div>

</div>
</div>
</div>
{{-- {{ route('product.rating.store') }} --}}
{{-- rate and write review  --}}
<div class="col-md-6 ">
<p class="my-1">Have you book this Hotel before?</p>
<p class="my-1">Rate it: *</p>
<form method="POST" class="reply-forms submit" id="main_form" action="{{route('review.store')}}"  enctype="multipart/form-data">

<input type="hidden" id="main_product_id" value="{{ $id }}">

<div class="d-flex">
<div class="star-container">
    <input type="radio" required name="star" value="5" id="5" class="radio main_rating">
    <label class="label" for="5">
     <span class="star ">
      &#x2729;
     </span>
    </label>

    <input type="radio" required name="star" value="4" id="4" class="radio main_rating">
    <label class="label" for="4">
      <span class="star">
        &#x2729;
       </span>
    </label>

    <input type="radio" required name="star" value="3" id="3" class="radio main_rating">
    <label class="label" for="3">
      <span class="star">
        &#x2729;
       </span>
    </label>

    <input type="radio" required name="star" value="2" id="2" class="radio main_rating">
    <label class="label" for="2">
      <span class="star">
        &#x2729;
       </span>
    </label>

    <input type="radio" required name="star" value="1" id="1" class="radio main_rating">
    <label class="label" for="1">
      <span class="star">
        &#x2729;
       </span>
    </label>
</div>

</div>
<textarea placeholder="Write comment" rows="2" name="comment" id="main_comment" required></textarea>

<input type="file" name="file" id="main_file" class="form-control d-none">
<br>
@auth

@php
    $check=DB::table('bookings')->where('user_id',Auth::user()->id)->where('place_id',$id)->first()
@endphp

<button class=" nsnbtn d-block custom-bg-primary text-white custom-fw-600 w-100" id="submit"
@if ($check)
    type="submit"
@else 
{{-- type="button"
onclick='alert("It seems you do not have booked this hotel before")'
return false --}}
@endif

>Submit</button>
@else   
<button type="button"  class=" nsnbtn d-block custom-bg-primary text-white custom-fw-600 w-100" onclick="window.location='{{route('user_login')}}'" >Login To write review</button>
@endauth


</form>


</div>
{{-- rate and write review end --}}

</div>


<div class="comment-thread px-0 px-md-2">
<!-- Comment 1 start -->
<details open class="comment" id="comment-1">
@foreach ($ratings as $item)
@if ($item->uid!=8)
    
<summary>
<div class="comment-heading">

  <div class="comment-info">
      <a class="comment-author d-flex  align-items-center text-decoration-none mb-0 pb-0">
        <img src=" 
  {{ asset('frontend/user.png') }} " alt="{{ $item->name }}" class="img-fluid rounded-circle" width="40" height="40">   
        <span class="ml-2">
          {{ $item->name }}
        </span>
         </a>
       
        <span class="d-flex justify-content-left align-items-center mt-0 pt-0 ml-0 ml-md-5">
          @for ($i = 0; $i < $item->rating; $i++)
            <span class=" custom-text-orange custom-fs-20">
             <i class="fas fa-star"></i>
             </span>
          @endfor 
          @for ($i = 0; $i < 5-$item->rating; $i++)
            <span class="custom-fs-20 ">
             <i class="far fa-star"></i>
             </span>
              
          @endfor &nbsp;{{ carbon\carbon::parse($item->created_at)->format('d/m/Y') }}
        
     
        </span>  
  </div>
</div>
</summary>

<div class="comment-body my-1 px-0 px-md-2">
<p class=" imgs ml-0 ml-md-5" >
  {!!  $item->feedback  !!}

</p>

<a class="custom-fw-400 reply-form-link ml-0 ml-md-5 badge px-3   bluebtn "  data-id="comment-{{ $item->id }}-reply-form" href="#">Reply</a>

<!-- Reply form start -->
<div class="container px-0 mx-0 ml-0 ml-md-5">
<div class="row">
<div class="col-md-6">


<form method="POST" class="reply-form d-none reply " id="comment-{{ $item->id }}-reply-form" action="{{route('review.reply')}}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="comment_id" value="{{ $item->id }}">
  <textarea placeholder="Reply to comment" rows="2"  name="comment" required ></textarea>

  <button id="reset" type="reset" class="d-none"></button>
  <button type="submit" class="badge custom-bg-primary border-0 outline-none ">Submit</button>
  <a  class="badge bg-dark border-0 outline-none cancel text-decoration-none text-white" data-id="comments-{{ $item->id }}-reply-form" href="#">Cancel</a>

</form>
</div>
</div>
</div>
<!-- Reply form end -->
{{-- fetching reply  --}}
@php
$reply=DB::table('replies')->join('users','users.id','replies.user_id')->select('users.name','users.id as uid','replies.*')->where('comment_id',$item->id)->get();
@endphp
@foreach ($reply as $items)
<div class="replies">
<!-- Comment 2 start -->
<details open class="comment" id="comment-2">

<summary>

        <div class="comment-info">
          <a class="comment-author d-inline  text-decoration-none mb-0 pb-0">
            <img src="{{ asset('frontend/user.png') }} " alt="user image" class="img-fluid rounded-circle" width="40" height="40"> 
            
             {{ $items->name }}  

             </a>
             &nbsp;{{ carbon\carbon::parse($items->created_at)->format('d/m/y') }}</span>
        </div>
</summary>

<div class="comment-body ">
    <p class="imgs ml-0 ml-md-5">
        {!! $items->comment  !!}
    </p>
    <a class="custom-fw-400 reply-form-link bluebtn badge px-3"  data-id="comments-{{ $items->id }}-reply-form" href="#">Reply</a>

    <!-- Reply form start -->
    <div class="container px-0 mx-0">
    <div class="row">
    <div class="col-md-6">
    <form method="POST" class="reply-form d-none reply" id="comments-{{ $items->id }}-reply-form" action="{{route('review.reply')}}" enctype="multipart/form-data" >
      @csrf
      <input type="hidden" name="comment_id" value="{{ $item->id }}">
        <textarea placeholder="Reply to comment" rows="2" name="comment" required ></textarea>
        <button type="submit" class="badge custom-bg-primary border-0 outline-none">Submit</button>
        <a  class="badge bg-dark border-0 outline-none cancel text-decoration-none" data-id="comments-{{ $items->id }}-reply-form" href="#">Cancel</a>
 
    </form>
  </div>
</div>
</div>
</div>
</details>
<!-- Comment 2 end -->
{{-- 
<a href="#load-more">Load more replies</a> --}}
</div>
@endforeach

</div>
@endif

@endforeach


</details>
<!-- Comment 1 end -->
{{-- {{ $rating->links() }} --}}
</div>
</div>
</div>