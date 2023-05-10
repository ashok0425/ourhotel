@extends('admin.layout.master')

@push('style')
  <style>
    .sideNavBar{
        height: 100%;
  width: 0;
  position: fixed;
  z-index: 1;
  top: 0;
  right: 0;
  background-color: rgba(0, 0, 0, .4);
  transition: 0.5s;
  overflow: auto;
    }
.sidenav {
  width: 0;
  z-index: 9999999999;
  background-color: #fff;
  transition: 0.5s;
  padding-top: 60px;
  box-shadow: 0 0 5px gray;
  pointer-events: none;
  margin-left: auto;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
  cursor: pointer;
  pointer-events:initial;
}



@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}</style>  
@endpush
@section('content')
    <div class="card">
      
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    User Detail ({{$user->name}})
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
                            <td>{{ucfirst($user->name)}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{$user->email}}</td>
                        </tr>

                        <tr>
                            <td>Phone</td>
                            <td>{{$user->phone}}</td>
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
                            <td>Referral wallet </td>
                            <td>100</td>
                        </tr>

                        <tr>
                            <td>Total Booking Wallet</td>
                            <td>2000</td>
                        </tr>
                        <tr>
                            <td>Paid Booking Wallet</td>
                            <td>1000</td>
                        </tr>

                        <tr>
                            <td>Pending Booking Wallet</td>
                            <td>1000</td>
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Booked By
                        </th>
                        <th>
                            Booked For
                        </th>
                        <th>
                            Property
                        </th>
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
                            <td>
                                {{ $booking->user->name }}
                            </td>
                            <td>
                                {{ $booking->name }}
                                <br>
                                {{ $booking->phone }}
                            </td>
                           
                            <td>
                           {{$booking->property->name}}
                             </td>
                             <td>
                                {{Carbon\Carbon::parse($booking->check_in)->format('d/m/Y')}} ({{Carbon\Carbon::parse($booking->booked_hour_from)->format('G:i:A')}}) 
                                <br>
                                {{Carbon\Carbon::parse($booking->check_out)->format('d/m/Y')}}
                                ({{Carbon\Carbon::parse($booking->booked_hour_to)->format('G:i:A')}})
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
                            <td>
                                <a url="{{ route('admin.bookings.show', $booking) }}" class="btn btn-primary btn-sm" onclick="openNav(this)" >view</a>
                                <a url="{{ route('admin.bookings.update', $booking) }}" class="btn btn-primary btn-sm updateSatusBtn" data-toggle="modal" data-target="#updatestatus" ><i class="fas fa-edit"></i></a>
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
                            {{ $property->user->name }}
                        </td>
                        <td>
                            {{ $property->name }}
                        </td>
                        <td>
                           <img src="{{ getImage($property->thumbnail) }}" alt=" {{ $property->name }}" width="70" height="70">
                        </td>
                        <td>
                       {{$property->address}}
                         </td>
                        <td>
                            @if ($property->status == 1)
                                <span class="badge bg-success text-white">Active</span>
                            @else
                                <span class="badge bg-danger text-white">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-primary btn-sm">Edit</a>
                            <a href="{{ route('admin.properties.destroy', $property) }}"
                                class="btn btn-danger btn-sm delete_row" data-toggle="modal"
                                data-target="#deleteModal">Delete</a>
                                <br>
                                <br>

                                <a href="{{ route('admin.rooms.index', ['property_id'=>$property->id]) }}"
                                class="btn btn-info btn-sm" >Manage Room</a>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>




{{-- side nav for booking detail  --}}
<div class="sideNavBar" onclick="">
    <div id="mySidenav" class="sidenav">
       
     <div class="content"></div>
      </div>
    </div>

  
  <!-- Modal -->
  <div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="updatestatusLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updatestatusLabel">Update Booking status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body  pb-2">
        
            <form action="" method="POST" id="updateSatusForm">
                @method('PATCH')
                @csrf
                <select name="status" id="" class="form-control form-select" required>
                    <option value="1">Approved</option>
                    <option value="2">Checkin</option>
                    <option value="3">Checkout</option>
                    <option value="4">Cancel</option>
                </select>
     
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary  btn-rounded" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-rounded">Save changes</button>
        </div>
    </form>

    </div>
      </div>
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