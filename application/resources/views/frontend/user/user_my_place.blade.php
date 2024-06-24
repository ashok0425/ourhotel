@extends('frontend.layouts.master')

@section('main')
    <div class="">
        @include('frontend.user.breadcrum', ['title' => 'Booking'])
        <div class="">
            <div class="container my-5">
                <div class="">

                    <div class="nsnhotelsbookinginformation">
                        <div class="row">
                            <div class="col-12 col-sm-3 col-md-3">

                                @include('frontend.user.sidebar')

                            </div>

                            <div class="col-12 col-sm-9 col-md-9 bg-white">
                                {{-- tab for booking section  --}}
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active custom-text-primary custom-fs-18 custom-fw-600"
                                            id="all-tap" data-toggle="tab" href="#all" role="tab"
                                            aria-controls="Upcoming" aria-selected="true">All</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link  custom-text-primary custom-fs-18 custom-fw-600"
                                            id="Upcoming-tab" data-toggle="tab" href="#Upcoming" role="tab"
                                            aria-controls="Upcoming" aria-selected="true">Upcoming</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-text-primary custom-fs-18 custom-fw-600"
                                            id="Cancelled-tab" data-toggle="tab" href="#Cancelled" role="tab"
                                            aria-controls="Cancelled" aria-selected="false">Cancelled</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link custom-text-primary custom-fs-18 custom-fw-600"
                                            id="Completed-tab" data-toggle="tab" href="#Completed" role="tab"
                                            aria-controls="Completed" aria-selected="false">Completed</a>
                                    </li>
                                </ul>

                                {{-- tab content  --}}


                                <div class="tab-content" id="myTabContent">
                                    {{-- upcoming booking  --}}
                                    <div class="tab-pane fade show active" id="all" role="tabpanel"
                                        aria-labelledby="Upcoming-tab">
                                        <div class="table-responsive">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Booking ID</th>
                                                        <th>CheckIn/Out</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
                                                        <th>Payment Mode/status</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bookings as $booking)
                                                        @if (count($bookings) < 0)
                                                            <tr>
                                                                <td colspan="5" class="text-center">
                                                                    No booking till date
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        @include('frontend.user.booking_table', [
                                                            'booking' => $booking,
                                                        ])
                                                    @endforeach

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>

                                    {{-- upcoming booking  --}}
                                    <div class="tab-pane fade show " id="Upcoming" role="tabpanel"
                                        aria-labelledby="Upcoming-tab">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Booking ID</th>
                                                        <th>CheckIn/Out</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
                                                        <th>Payment Mode/status</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bookings as $booking)
                                                        @if ($booking->status == 2)
                                                            @include('frontend.user.booking_table', [
                                                                'booking' => $booking,
                                                            ])
                                                        @endif
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>


                                    {{-- cancelled booking  --}}
                                    <div class="tab-pane fade show " id="Cancelled" role="tabpanel"
                                        aria-labelledby="Cancelled-tab">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Booking ID</th>
                                                        <th>CheckIn/Out</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
                                                        <th>Payment Mode/status</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bookings as $booking)
                                                        @if ($booking->status == 0)
                                                            @include('frontend.user.booking_table', [
                                                                'booking' => $booking,
                                                            ])
                                                        @endif
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>





                                    {{-- Completed booking  --}}
                                    <div class="tab-pane fade show " id="Completed" role="tabpanel"
                                        aria-labelledby="Completed-tab">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Booking ID</th>
                                                        <th>CheckIn/Out</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
                                                        <th>Payment Mode/status</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($bookings as $booking)
                                                        @if ($booking->status == 1)
                                                            @include('frontend.user.booking_table', [
                                                                'booking' => $booking,
                                                            ])
                                                        @endif
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>




            </div>

        </div>
    </div>



<!--Cancel reason Modal -->
<div class="modal" id="bookingCancelModal" tabindex="-1" role="dialog" aria-labelledby="bookingCancelModalLabel" aria-hidden="true" sty>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex">
         <div>
            <h5 class="modal-title" id="bookingCancelModalLabel">Reason For Cancel?</h5>
            <p>Write a reason for booking cancellation.</p>
         </div>

        </div>
        <div class="modal-body">
         <form action="{{route('cancel_booking')}}" method="post" class="mb-2">
            @csrf
                <input type="hidden" id="property_id" name="id" >

                <textarea placeholder="write a reason for booking cancel...." rows="2" name="reason" id="reason" required class="form-control"></textarea>
                   <br>
               <div class="text-right d-flex">
                <button class=" nsnbtn  bg-secondary text-white custom-fw-600 w-100" id="submit">Cancel</button>
                <button class=" nsnbtn custom-bg-primary text-white custom-fw-600 w-100" id="submit">Submit</button>

               </div>
                </form>

        </div>
      </div>
    </div>
  </div>



<!--Rate hotel Modal -->
<div class="modal" id="writereviewModal" tabindex="-1" role="dialog" aria-labelledby="writereviewLabel" aria-hidden="true" sty>
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex">
         <div>
            <h5 class="modal-title" id="writereviewLabel">   <p class="my-1">Have you book this Hotel before?</p>
                <p class="my-1">Rate it: *</p></h5>
         </div>

        </div>
        <div class="modal-body">
         <form action="{{route('user_my_reviews_store')}}" method="post" class="mb-2">
            @csrf
                <input type="hidden" id="property_id" name="property_id" >
                <div class="d-flex mb-3">
                <div class="star-container">
                    <input type="radio" required name="star" value="5" id="5" class="radio main_rating">
                    <label class="label" for="5">
                     <span class="star ">
                      &#x2729;
                     </span>
                    </label>

                    <input type="radio" required name="star" value="4" id="4" class="radio main_rating">
                    <label class="label" for="4">
                      <span class="star">
                        &#x2729;
                       </span>
                    </label>

                    <input type="radio" required name="star" value="3" id="3" class="radio main_rating">
                    <label class="label" for="3">
                      <span class="star">
                        &#x2729;
                       </span>
                    </label>

                    <input type="radio" required name="star" value="2" id="2" class="radio main_rating">
                    <label class="label" for="2">
                      <span class="star">
                        &#x2729;
                       </span>
                    </label>

                    <input type="radio" required name="star" value="1" id="1" class="radio main_rating">
                    <label class="label" for="1">
                      <span class="star">
                        &#x2729;
                       </span>
                    </label>
                </div>

                </div>
                <textarea placeholder="Write comment" rows="2" name="comment" id="feedback" required class="form-control"></textarea>
                   <br>
               <div class="text-right d-flex">
                <button class=" nsnbtn  bg-secondary text-white custom-fw-600 w-100" id="submit">Cancel</button>
                <button class=" nsnbtn custom-bg-primary text-white custom-fw-600 w-100" id="submit">Submit</button>

               </div>
                </form>

        </div>
      </div>
    </div>
  </div>



@stop

@push('scripts')
    <script>
    $(document).on('click','#writereviewBtn',function(){
       $property_id=$(this).data('id');
       $('#property_id').val($property_id);
    })
    </script>
@endpush
