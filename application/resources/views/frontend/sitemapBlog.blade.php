<?php echo'<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
         xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
         xmlns:example="http://www.example.com/schemas/example_schema"> <!-- namespace extension -->
        <!--  created by Khalid Hossain. Also, he is watching you :)  -->


    @foreach($datas as $data)
    <url>
    <loc>https://nsnhotels.com/post/{{$data->slug}}-{{$data->id}}</loc>
    <lastmod>{{date(DATE_ATOM, strtotime($data->created_at))}}</lastmod>
    <changefreq>daily</changefreq>
    <priority>0.9</priority>
    </url>
    @endforeach
</urlset>