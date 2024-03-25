<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
        
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($datas as $data)
    <sitemap>
        <loc>https://nsnhotels.com/sitemapHotel.xml/{{ $data->slug }}</loc>
    </sitemap>
    @endforeach
</sitemapindex>