@extends('admin.layout.master')

@push('style')
</style>
@endpush
@section('content')

<div class="mb-3 align-items-center d-flex justify-content-end">
    <form action="" method="get" class="d-flex align-items-between">

        <div>
            <label for="">Status</label>
            <select name="status" id="" class="form-select form-control">
                <option value="">Status</option>
                <option value="0" {{request()->query('status')==2? 'selected':''}}>Upcoming</option>
                <option value="1" {{request()->query('status')==1? 'selected':''}}>Approved</option>
                <option value="4" {{request()->query('status')==0? 'selected':''}}>Cancelled</option>

            </select>
        </div>

        <div>
            <label for="">From</label>
            <input type="date" name="from" id="" class="form-control">
        </div>
        <div>
            <label for="">To</label>
            <input type="date" name="to" id="" class="form-control">
        </div>
        <div>
            <label for="">Search Keyword</label>
            <input type="search" name="keyword" id="" class="form-control" value="{{request()->query('keyword')}}" placeholder="Enter search keyword">
        </div>

        <div>
        <button class="btn btn-info rounded-0 mt-4">Search</button>
        </div>
        <div>
            <a href="{{route('tour_bookings.create')}}" class="btn btn-primary rounded-0 mt-4">Book Tour</a>
        </div>
    </form>
</div>

    <div class="card">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                   Tour Booking List
                </div>

            </div>
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>Booking Id</th>
                        <th>
                           User
                        </th>

                        <th>
                            Name
                        </th>

                        <th>Detail</th>
                        <th>Amount</th>
                        <th>Date</th>

                        <th>
                            Status
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap" style="max-width: 100px">

                                {{$booking->booking_id}}
                               </td>
                            <td class="text-wrap" style="max-width: 200px;">
                          <div class="text-wrap">
                                 <a href="">{{$booking->user?$booking->user->name:"User Deleted"}}</a>
                          </div>
                            </td>

                            <td class="text-wrap" style="max-width: 200px;">

                              {{$booking->tour_name}}
                             </td>
                             <td>

                               No.of Adult: {{$booking->no_of_adult}}
                                <br>
                               No.of Child: {{$booking->no_of_child}}
                               <br>
                               Payment Type: {{$booking->payment_type}}

                            </td>
                             <td>{{$booking->amount}}</td>

                             <td>
                                {{Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y')}}
                                <br>
                                {{Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y')}}

                                  </td>
                            <td>
                                @if ($booking->status == 2)
                                <span class="badge bg-danger text-white">upcoming</span>
                            @endif
                            @if ($booking->status == 1)
                                <span class="badge bg-success text-white">Approved</span>
                            @endif
                          @if ($booking->status == 0)
                                        <span class="badge bg-danger text-white">Cancelled</span>
                                    @endif
                            </td>
                            <td style="max-width: 50px">
                                <ul class="nav ">

                                    <li class="nav-item">
                                        <a class="nav-link text-dark dropdown-toggle" data-toggle="dropdown" href="#"
                                            role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h fa-2x"></i></a>
                                        <div class="dropdown-menu">
                                            <a href="" class="text-dark dropdown-item updateSatusBtn"
                                            data-toggle="modal" data-target="#updatestatus" data-booking_id="{{$booking->id}}">Change Status</a>

                                        </div>
                                    </li>
                                    </ul>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{$bookings->links()}}
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

            <form action="{{route('tour_bookings.status')}}" method="POST" id="updateSatusForm">
                @method('PATCH')
                @csrf
                <input type="hidden" id="booking_id" name="booking_id">
                @method('PATCH')
                @csrf
                <select name="status" id="" class="form-control form-select" required>
                    <option value="1">Completed</option>
                    <option value="0">Cancel</option>
                </select>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary  btn-rounded" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-rounded">Save</button>
        </div>
    </form>

    </div>
      </div>
    </div>
  </div>
@endsection

@push('script')

<script>


    // update booking status
    $(document).on('click','.updateSatusBtn',function(){
        let bookingId=$(this).data('booking_id');
     $('#booking_id').val(bookingId)
    })

    </script>
@endpush
