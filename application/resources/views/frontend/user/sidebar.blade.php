<div class="shadow-sm  bg-white py-2 my-4 my-md-0">
    <div class="text-center">
        <div class=" mx-auto mb-2">
            <img src="{{ getImageUrl(auth()->user()->avatar)}}" alt="User Profile" class="mx-auto w-50 border  img-fluid" />
        </div>
        <p class="text-center custom-fw-700 custom-fs-20">Welcome</p>
        <div class="nsnhotelsname text-center custom-fw-700 custom-fs-20 ">{{user()->name}}</div>
    </div>
    <ul class="row m-0 bottomdata">
            <li class="col-12 my-2">
                <a href="{{route('user_profile')}}" class="custom-fs-16 custom-fw-700 py-0 my-0 @if(Request()->segment(2)=='profile') custom-text-primary @else custom-text-gray-2  @endif"><i class="fas fa-user"></i> Profile</a>
    
            </li>
        <li class="col-12 my-2">

            <a href="{{route('user_my_place')}}" class=" custom-fs-16 custom-fw-700 py-0 my-0 @if(Request()->segment(2)=='my-place') custom-text-primary @else custom-text-gray-2  @endif"><i class="fas fa-briefcase"></i>   Booking</a>
        </li>

        <li class="col-12 my-2">

            <a href="{{route('user_my_wallet')}}" class=" custom-fs-16 custom-fw-700 py-0 my-0 @if(Request()->segment(2)=='my-wallet') custom-text-primary @else custom-text-gray-2  @endif"><i class="fas fa-wallet"></i> Wallet</a>
        </li>
      
        <li class="col-12 my-2">
            <a   class="custom-text-gray-2 custom-fs-16 custom-fw-700 py-0 my-0" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> {{__('Log Out')}}</a>
               
        </li>
    </ul>
</div>

