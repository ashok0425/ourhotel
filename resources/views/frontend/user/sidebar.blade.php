<div class="shadow-sm  bg-white py-2 my-4 my-md-0">
    <div class="text-center">
        <div class=" mx-auto mb-2">
            <img src="{{ getImageUrl(auth()->user()->profile_photo_path)}}" alt="User Profile" class="mx-auto  border  img-flui rounded-circle" width="100" height="100" style="object-fit: fill"/>
        </div>
        <p class="text-center custom-fw-700 custom-fs-20">Welcome</p>
        <div class="nsnhotelsname text-center custom-fw-700 custom-fs-20 ">{{auth()->user()->name}}</div>
    </div>
    <ul class="row m-0 bottomdata">
            <li class="col-12 my-2">
                <a href="{{route('user_profile')}}" class="custom-fs-16 custom-fw-700 py-0 my-0 @if(Request()->segment(2)=='profile') custom-text-primary @else custom-text-gray-2  @endif"><i class="fas fa-user"></i> Profile</a>

            </li>
        <li class="col-12 my-2">

            <a href="{{route('user_my_place')}}" class=" custom-fs-16 custom-fw-700 py-0 my-0 @if(Request()->segment(2)=='bookings') custom-text-primary @else custom-text-gray-2  @endif"><i class="fas fa-briefcase"></i>   Booking</a>
        </li>

        <li class="col-12 my-2">

            <a href="{{route('user_my_review')}}" class=" custom-fs-16 custom-fw-700 py-0 my-0 @if(Request()->segment(2)=='reviews') custom-text-primary @else custom-text-gray-2  @endif"><i class="fas fa-comment"></i> Review</a>
        </li>

        <li class="col-12 my-2">

            <a href="{{route('user_my_wallet')}}" class=" custom-fs-16 custom-fw-700 py-0 my-0 @if(Request()->segment(2)=='wallets') custom-text-primary @else custom-text-gray-2  @endif"><i class="fas fa-wallet"></i> Wallet</a>
        </li>

        <li class="col-12 my-2">
            <a   class="custom-text-gray-2 custom-fs-16 custom-fw-700 py-0 my-0" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> {{__('Log Out')}}</a>

        </li>
        <li class="col-12 my-2">
            @if (Auth::check() && Auth::user()->is_partner)
            <a href="/dashboard" class="nav-link custom-bg-primary custom-border-radius-20 text-center text-white py-2 "><i class="fas fa-money-check"></i>
                <span>Login to partner panel</span></a>
                @else
                <a href="/become-a-partner" class="nav-link custom-bg-primary custom-border-radius-20 text-center text-white py-2 "><i class="fas fa-money-check"></i>
                    <span> &nbsp; Become  Partner</span></a>
            @endif

        </li>
    </ul>
</div>



