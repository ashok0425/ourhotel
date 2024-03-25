<div class="mt-5 container custom-bg-white">
    <br>
    <div class="p-1">
        <div class="d-flex justify-content-between align-items-center mb-2 mb-2 p-3 p-md-0">
            <h2 class="custom-fw-800  bold text-dark custom-fs-20 custom-fw-600 mb-3 pt-4">NSN Resort</h2>
            <div><a href=""
                    class="btn custom-border-radius-20 custom-bg-primary custom-text-white custom-fw-800 custom-fs-14 hover-on-white">View
                    All ➡</a></div>
        </div>
        <div class="row mt-2 mt-md-0 px-md-3 pb-4">
            @foreach ($nsn_resort as $place)
                <div class="col-md-3 col-lg-3 col-6 col-sm-6 mx-0 px-0">
                    @include('frontend.partials.card1', $place)
                </div>
            @endforeach
        </div>
    </div>
</div>
