<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
      <a class="navbar-brand brand-logo mr-5" href="{{route('dashboard')}}"><img src="{{ getImageUrl(setting('logo')) }}" class="mr-2" alt="logo"/></a>
      <a class="navbar-brand brand-logo-mini" href="{{route('dashboard')}}"><img src="{{ getImageUrl(setting('logo')) }}" alt="logo"/></a>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <a class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
        <span class="icon-menu"></span>
      </a>
      <ul class="navbar-nav mr-lg-2">
        <li class="nav-item nav-search d-none d-lg-block">
          <div class="input-group">
            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
              <span class="input-group-text" id="search">
                <i class="icon-search"></i>
              </span>
            </div>
            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
          </div>
        </li>
      </ul>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item dropdown">
          <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="icon-bell mx-0"></i>
            <span class="count"></span>
          </a>
          @php
             $bookings= App\Models\Booking::query()
           ->when(Auth::user()->is_partner,function($query) {
            $query->whereHas('property', function ($query) {
                $query->where('owner_id',Auth::user()->id );
            });
           })->whereDate('created_at','>=',today()->subDays(30))->where('status',2)->get();
          @endphp

          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">

            @forelse ($bookings as $booking)
            <a class="dropdown-item preview-item" href="{{route('bookings.show',$booking)}}">

              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">New Booking #{{$booking->booking_id}}</h6>
                <p class="font-weight-light small-text mb-0 text-muted">
                  You have a new booking.
                </p>
              </div>
            </a>
            @empty
            <p class="mb-0 font-weight-normal float-left dropdown-header">No Booking Yet</p>

            @endforelse

          </div>
        </li>
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle" href="/admin/logout">
            Logout
          </a>

        </li>

      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
        <span class="icon-menu"></span>
      </button>
    </div>
  </nav>
