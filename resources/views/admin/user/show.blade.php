@extends('admin.layout.master')

@push('style')
  <style></style>
@endpush
@section('content')
    <div class="card">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    User Detail ({{$user->name}})
                </div>
                <div>
                    Total Refer Amount ({{$user->referMoney()->where('is_used',0)->sum('price')}})
                </div>
            </div>

        </div>
    </div>

    {{-- user detail  --}}
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table w-100">
                        <tr>
                            <td>Name</td>
                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">{{ucfirst($user->name)}}
                                </div>
                                </td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">{{$user->email}}
                                </div>
                                </td>
                        </tr>

                        <tr>
                            <td>Phone</td>
                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">
                                {{$user->phone_number}}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Staus</td>
                            <td>
                                @if ($user->status == 1)
                                <span class="badge bg-success text-white">Active</span>
                            @else
                                <span class="badge bg-danger text-white">Blocked</span>
                            @endif
                            </td>
                        </tr>

                        <tr>
                            <td>Register On</td>
                            <td>{{Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <table class="table w-100">
                        <tr>
                            <td>Customer Type</td>
                            <td>Customer</td>
                        </tr>
                        <tr>
                            <td>Referral wallet Amount </td>
                            <td>{{$user->referMoney()->where('is_used',0)->sum('price')}}</td>
                        </tr>

                        <tr>
                            <td>Used Wallet Amount</td>
                            <td>{{$user->referMoney()->where('is_used',1)->sum('price')}}</td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- booking list  --}}
    <div class="card mt-3">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Booking List
                </div>

            </div>
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                           User Detail
                        </th>

                        <th>
                            Hotel
                        </th>

                        <th>Detail</th>
                        <th>Amount</th>
                        <th>
                            Check in/out
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($user->booking as $booking)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap" style="max-width: 200px;">
                          <div class="text-wrap">
                                 BY: <a href="">{{$booking->user?$booking->user->name:"User Deleted"}}</a>
                                <br>
                            {{ $booking->name }}
                            <br>
                            {{ $booking->phone_number }}
                          </div>
                            </td>

                            <td class="text-wrap" style="max-width: 200px;">
                           @if ($booking->property_id==0)
                              {{$booking->hotel_data['name']??''}}

                              @else
                              {{$booking->property?$booking->property->name:"Hotel Deleted"}}
                           @endif
                             </td>
                             <td>
                                Room Type: {{$booking->booking_type}}

                                <br>
                                Booking Type: {{$booking->room_type}}
                                <br>
                               No.of Adult: {{$booking->no_of_adult}}
                                <br>
                               No.of Child: {{$booking->no_of_child}}
                                <br>
                                No.of Room: {{$booking->no_of_room}}
                            </td>
                             <td>{{$booking->final_amount}}</td>

                             <td>
                                {{-- ({{Carbon\Carbon::parse($booking->booked_hour_from)->format('G:i:A')}}) --}}
                                {{-- ({{Carbon\Carbon::parse($booking->booked_hour_to)->format('G:i:A')}}) --}}
                                {{Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y')}}
                                <br>
                                {{Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y')}}

                                  </td>
                            <td>
                                @if ($booking->status == 0)
                                <span class="badge bg-danger text-white">Pending</span>
                            @endif
                            @if ($booking->status == 1)
                                <span class="badge bg-success text-white">Approved</span>
                            @endif

                            @if ($booking->status == 2)
                                <span class="badge bg-info text-white">Checkin</span>
                                @endif @if ($booking->status == 3)
                                    <span class="badge bg-warning text-white">Checkout</span>
                                    @endif @if ($booking->status == 4)
                                        <span class="badge bg-danger text-white">Cancelled</span>
                                    @endif
                            </td>
                            <td style="max-width: 50px">
                                <ul class="nav ">

                                    <li class="nav-item">
                                        <a class="nav-link text-dark dropdown-toggle" data-toggle="dropdown" href="#"
                                            role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h fa-2x"></i></a>
                                        <div class="dropdown-menu">
                                            <a href=""
                                            class="text-dark dropdown-item">Edit</a>

                                        </div>
                                    </li>
                                    </ul>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

{{-- property list  --}}
<div class="card mt-3">
    <div class="card-body table-responsive pt-3">
        <div class="card-title d-flex justify-content-between">
            <div>
                Property List
            </div>

        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Partner
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Thumbnail
                    </th>
                    <th>
                        Address
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Action
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($user->property as $property)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $property->owner?->name }}
                            <br>
                            {{ $property->owner?->email }}
                            <br>
                            {{ $property->owner?->phone_number }}

                        </td>
                        <td style="max-width: 220px;" class="text-wrap">
                            {{ $property->name }}
                        </td>
                        <td style="max-width: 150px;" class="text-wrap">
                            <a href="{{ getImageUrl($property->thumbnail) }}" target="_blank">
                           <img src="{{ getImageUrl($property->thumbnail) }}" alt="{{ $property->name }}" width="100" height="100">

                            </a>
                        </td>
                        <td style="max-width: 220px;" class="text-wrap">
                            {{ $property->address }}
                        </td>


                        <td>
                            @if ($property->status == 1)
                                <span class="badge bg-success text-white">Active</span>
                            @else
                                <span class="badge bg-danger text-white">Inactive</span>
                            @endif
                        </td>
                        <td>

                            <ul class="nav ">

                                <li class="nav-item">
                                    <a class="nav-link text-dark dropdown-toggle" data-toggle="dropdown" href="#"
                                        role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h fa-2x"></i></a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('properties.edit', $property) }}"
                                        class="text-dark dropdown-item">Edit</a>
                                        <a href="#"
                                                class="text-dark dropdown-item change_status" data-bs-toggle="modal"
                                                data-userId="{{$property->id}}"
                                                data-bs-target="#changeStatusModal">Delete</a>
                                                <a href="#"
                                                class="text-dark dropdown-item">View</a>
                                                <a href="{{ route('rooms.index', ['property_id'=>$property->id]) }}"
                                                    class="text-dark dropdown-item">Manage Room</a>
                                        <a href="{{ route('booking.create', ['property_id'=>$property->id]) }}"
                                            class="text-dark dropdown-item">Add Booking</a>
                                    </div>
                                </li>
                                </ul>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>


{{-- Refer Money list  --}}
<div class="card mt-3">
    <div class="card-body table-responsive pt-3">
        <div class="card-title d-flex justify-content-between">
            <div>
                Refer Money List
            </div>

        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Refer Type
                    </th>
                    <th>
                        Amount
                    </th>
                    <th>
                        Refer On
                    </th>
                    <th>
                        Is Used
                    </th>

                </tr>
            </thead>
            <tbody>
                @foreach ($user->referMoney as $refer)
                    <tr>
                        <td>
                            {{ $loop->iteration }}
                        </td>
                        <td>
                            {{ $property->refer->referel_type==1?'JOIN':"SHARE" }}
                        </td>
                        <td>
                            {{ $property->refer->price }}
                        </td>
                        <td>
                            {{ $property->refer->is_user?'Yes':'No' }}

                        </td>
                        <td style="max-width: 220px;" class="text-wrap">
                            {{ $property->name }}
                        </td>
                        <td>
                            <a href="{{ getImageUrl($property->thumbnail) }}" target="_blank">
                           <img src="{{ getImageUrl($property->thumbnail) }}" alt="{{ $property->name }}" width="100" height="100">

                            </a>
                        </td>
                        <td style="max-width: 220px;" class="text-wrap">
                            {{ $property->address }}
                        </td>


                        <td>
                            @if ($property->status == 1)
                                <span class="badge bg-success text-white">Active</span>
                            @else
                                <span class="badge bg-danger text-white">Inactive</span>
                            @endif
                        </td>
                        <td>

                            <ul class="nav ">

                                <li class="nav-item">
                                    <a class="nav-link text-dark dropdown-toggle" data-toggle="dropdown" href="#"
                                        role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h fa-2x"></i></a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('properties.edit', $property) }}"
                                        class="text-dark dropdown-item">Edit</a>
                                        <a href="#"
                                                class="text-dark dropdown-item change_status" data-bs-toggle="modal"
                                                data-userId="{{$property->id}}"
                                                data-bs-target="#changeStatusModal">Delete</a>
                                                <a href="#"
                                                class="text-dark dropdown-item">View</a>
                                                <a href="{{ route('rooms.index', ['property_id'=>$property->id]) }}"
                                                    class="text-dark dropdown-item">Manage Room</a>
                                        <a href="{{ route('booking.create', ['property_id'=>$property->id]) }}"
                                            class="text-dark dropdown-item">Add Booking</a>
                                    </div>
                                </li>
                                </ul>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection


@push('script')

<script>
    function openNav(ele) {
        url=ele.getAttribute('url')
      document.getElementById("mySidenav").style.width = "350px";
      document.querySelector('.sideNavBar').style.width = "100%";
      document.querySelector('.sideNavBar').style.backgroundColor = "rgba(0,0,0,0.4)";
      $.ajax({
        url:url,
        success:function(res){
            console.log(res)
            $('.content').html(res)
        }
      })
    }

    function closeNav() {
      document.getElementById("mySidenav").style.width = "0";
      document.querySelector('.sideNavBar').style.width = "0";
      document.querySelector('.sideNavBar').style.backgroundColor = "none";
    }

    // update booking status
    $(document).on('click','.updateSatusBtn',function(){
        let url=$(this).attr('url');
     $('#updateSatusForm').attr('action',url)
    })

    </script>
@endpush
