<script  type="text/javascript" src="{{ filepath('frontend/jss/jquery.min.js') }}"></script>
@if (request()->path()!='/')
<script defer src="{{ filepath('frontend/jss/popper.min.js') }}"></script>
<script defer src="{{ filepath('frontend/jss/jqueryeasing.js') }}"></script>
<script defer type="text/javascript" src="{{ filepath('frontend/jss/map-single.js') }}"></script>
<script  src="{{ filepath('frontend/build/js/intlTelInput.min.js') }}"></script>
<script defer
    src="https://maps.googleapis.com/maps/api/js?key={{ setting('goolge_map_api_key', 'AIzaSyBkYZ3pUwM6uOXwg9FrVfcbxXG_GmY0lrs') }}&callback=initAutocomplete&libraries=places&language={{ \Illuminate\Support\Facades\App::getLocale() }}">
</script>
<script rel src="{{ filepath('frontend/jquery.lazy.min.js') }}"></script>
@endif

<script defer src="{{ filepath('frontend/jss/plugins.js') }}"></script>
<script defer src="{{ filepath('frontend/jss/daterangepicker.js') }}"></script>
<script defer src="{{ filepath('frontend/jss/owl.carousel.min.js') }}"></script>
<script defer src="{{ filepath('frontend/jss/custom.js') }}"></script>
<script defer type="text/javascript" src="{{ asset('frontend/jss/custom3.js') }}"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script defer type="text/javascript" src="{{ filepath('frontend/jss/scripts.js') }}"></script>



