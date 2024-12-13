
@php
    $path=request()->path();
    $page=App\Models\Seo::where('path',$path)->first();

    if($page){
       $title=$page->title;
       $description=$page->description;
       $keyword=$page->keyword;
    }elseif(isset($seo)){
         $title=$seo['title'];
         $description=$seo['description'];
         $keyword=$seo['keyword'];
    }else{
        $title="NSN HOTELS -The Best Online Hotel Booking Website";
         $description="NSN Hotels provides the best online hotel booking site in India. Get the best hotel prices and discounts on your online hotel bookings.";
         $keyword="online hotel booking, book hotels online";
    }

@endphp

<title>{{$title}}</title>
<meta name="description" content="{{$description}}">
<meta name="keywords" content="{{$keyword}}">
<link rel="canonical" href="{{request()->url()}}"/>
<meta property="og:title" content="{{$title}}" />
<meta property="og:description" content="{{$description}}" />
<meta property="og:type" content="website" />
<meta property="og:image" content="https://d27s5h82rwvc4v.cloudfront.net/uploads/659be093327411704714387.jpeg" />
<meta property="og:site_name" content="{{$title}}" />
<meta property="og:url" content="{{request()->url()}}" />
<meta name="twitter:title" content="{{$title}}" />
<meta name="twitter:description" content="{{$description}}" />
<meta name="twitter:site" content="@HotelsNsn" />
<meta name="twitter:image" content="https://d27s5h82rwvc4v.cloudfront.net/uploads/659be093327411704714387.jpeg" />
