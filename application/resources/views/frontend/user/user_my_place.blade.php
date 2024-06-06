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
                                                        <th>CheckIn/ChekOut</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
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
                                                        <th>CheckIn/ChekOut</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
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
                                                        <th>CheckIn/ChekOut</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
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
                                                        <th>CheckIn/ChekOut</th>
                                                        <th>Hotel name</th>
                                                        <th>No. of Guest</th>
                                                        <th>No. of Rooms</th>
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
@stop

