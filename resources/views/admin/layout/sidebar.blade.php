
  <!-- partial -->
  <!-- partial:partials/_sidebar.html -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{route('dashboard')}}">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>

      @if (Auth::user()->is_admin)
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <i class="icon-layout menu-icon"></i>
          <span class="menu-title">Primary Setup</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.states.index')}}">State</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.cities.index')}}">City</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.categories.index')}}">Category</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.locations.index')}}">Location</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.propertyTypes.index')}}">Hotel Type</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.amenities.index')}}">Amenity</a></li>

          </ul>
        </div>
      </li>
      @endif

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">Hotel</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('properties.index')}}">All Hotel</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('rooms.index')}}">All Rooms</a></li>
          </ul>
        </div>
      </li>



      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#booking-elements" aria-expanded="false" aria-controls="booking-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">Booking</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="booking-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('bookings.index',['status'=>2])}}">New Booking</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('bookings.index')}}">All Booking</a></li>

          </ul>
        </div>
      </li>

      @if (Auth::user()->is_admin || Auth::user()->is_agent)

      <li class="nav-item">
        <a class="nav-link" href="{{route('tour_bookings.index')}}">
          <i class="fas fa-envelope menu-icon"></i>
          <span class="menu-title">Tour Booking</span>
        </a>
      </li>
      @endif



      @if (Auth::user()->is_admin)
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#user-elements" aria-expanded="false" aria-controls="user-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">User Managements</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="user-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index',['is_user'=>1])}}">Users</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index',['is_partner'=>1])}}">Partners</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index',['is_agent'=>1])}}">Agent</a></li>

          </ul>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#general-elements" aria-expanded="false" aria-controls="general-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">General Setting</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="general-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.blogs.index')}}">Blog</a></li>
            {{-- <li class="nav-item"><a class="nav-link" href="{{route('admin.banners.index')}}">Banner</a></li> --}}
            <li class="nav-item"><a class="nav-link" href="{{route('admin.websites.edit',1)}}">cms</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.faqs.index')}}">FAQ</a></li>

          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#enquiry-elements" aria-expanded="false" aria-controls="enquiry-elements">
          <i class="fas fa-phone menu-icon"></i>
          <span class="menu-title">Enquiry/Request</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="enquiry-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.enquries.index',['type'=>1])}}">General Enquiry</a></li>

            <li class="nav-item"><a class="nav-link" href="{{route('admin.enquries.index',['type'=>3])}}">Corporate</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.enquries.index',['type'=>2])}}">Become Partner</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.enquries.index',['type'=>4])}}">Subscriber List</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.coupons.index')}}">
          <i class="fas fa-bell menu-icon"></i>
          <span class="menu-title">Offers</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.fcms.index')}}">
          <i class="fas fa-envelope menu-icon"></i>
          <span class="menu-title">Fcm Notification</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#refer-elements" aria-expanded="false" aria-controls="user-elements">
          <i class="fas fa-share menu-icon"></i>
          <span class="menu-title">Refers</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="refer-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.refer_prices.index')}}">Refer Price</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.refer_moneys')}}">All Referel</a></li>

          </ul>
        </div>
      </li>
     @endif

     {{-- @if (Auth::user()->isisSeoExpert||Auth::user()->is_admin)
     <li class="nav-item">
        <a class="nav-link" href="{{route('seos.index')}}">
          <i class="fas fa-envelope menu-icon"></i>
          <span class="menu-title">Seo</span>
        </a>
      </li>
     @endif --}}

    </ul>

  </nav>
