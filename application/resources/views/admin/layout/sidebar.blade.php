
  <!-- partial -->
  <!-- partial:partials/_sidebar.html -->
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="index.html">
          <i class="icon-grid menu-icon"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
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
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.propertyTypes.index')}}">Property Type</a></li>
            <li class="nav-item"> <a class="nav-link" href="{{route('admin.amenities.index')}}">Amenity</a></li>

          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">Property</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="form-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.properties.index')}}">All Property</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.rooms.index')}}">All Rooms</a></li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.tour_bookings.index')}}">
          <i class="fas fa-envelope menu-icon"></i>
          <span class="menu-title">Tour Booking</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#booking-elements" aria-expanded="false" aria-controls="booking-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">Booking</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="booking-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.bookings.index',['status'=>0])}}">New Booking</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.bookings.index')}}">All Booking</a></li>

          </ul>
        </div>
      </li>



      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#user-elements" aria-expanded="false" aria-controls="user-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">User Managements</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="user-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index')}}">Users</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.users.index',['partner'=>1])}}">Partners</a></li>
          </ul>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#general-elements" aria-expanded="false" aria-controls="user-elements">
          <i class="icon-columns menu-icon"></i>
          <span class="menu-title">General Setting</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="general-elements">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item"><a class="nav-link" href="{{route('admin.blogs.index')}}">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.banners.index')}}">Banner</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.websites.edit',1)}}">cms</a></li>
            <li class="nav-item"><a class="nav-link" href="{{route('admin.faqs.index')}}">FAQ</a></li>

          </ul>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.coupons.index')}}">
          <i class="fas fa-envelope menu-icon"></i>
          <span class="menu-title">Offers</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.refer_prices.index')}}">
            <i class="fas fa-redo menu-icon"></i>
          <span class="menu-title">Refer Price</span>
        </a>
      </li>
    </ul>
  </nav>
