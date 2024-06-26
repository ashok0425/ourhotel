@extends('admin.layout.master')
@section('content')
<div class="main-pnel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">Welcome {{Auth::user()->name}}</h3>
            <h6 class="font-weight-normal mb-0">All systems are running smoothly! You have <span class="text-primary">
               {{$pendingBooking}}  booking for today!

            </span></h6>
          </div>

        </div>
      </div>
    </div>
    <div class="row">



      <div class="col-md-6 grid-margin transparent">
        <div class="row">
          <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-tale">
              <div class="card-body">
                <p class="mb-4">Today’s Bookings</p>
                <p class="fs-30 mb-2">{{$todayBooking}}</p>
                {{-- <p>10.00% (30 days)</p> --}}
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-4 stretch-card transparent">
            <div class="card card-dark-blue">
              <div class="card-body">
                <p class="mb-4">Total Bookings</p>
                <p class="fs-30 mb-2">{{$allBooking}}</p>
                {{-- <p>22.00% (30 days)</p> --}}
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
            <div class="card card-light-blue">
              <div class="card-body">
                <p class="mb-4">Amount of Today Booking</p>
                <p class="fs-30 mb-2">{{$todayBookingAmount}}</p>
              </div>
            </div>
          </div>
          <div class="col-md-6 stretch-card transparent">
            <div class="card card-light-danger">
              <div class="card-body">
                <p class="mb-4">Amount of All Booking</p>
                <p class="fs-30 mb-2">{{$allBookingAmount}}</p>
                {{-- <p>0.22% (30 days)</p> --}}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="com-md-6">
    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
</html>
      </div>


      <div class="col-md-12 grid-margin stretch-card mt-3">
        <div class="card tale-bg">
            <div class="card-body">
            <p class="card-title">Upcoming Booking</p>
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
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap" style="max-width: 200px;">
                          <div class="text-wrap">

                                 @if (Auth::user()->is_admin)
                                 BY:   <a href="">{{$booking->user?$booking->user->name:"User Deleted"}}</a>
                                 @else
                                 {{$booking->user?$booking->user->name:"User Deleted"}}
                                 @endif

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
                                            <a href="{{route('bookings.show',$booking)}}" class="text-dark dropdown-item">View</a>
                                            <a href="{{route('bookings.edit',$booking)}}" class="text-dark dropdown-item">Download Invoice</a>
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

        </div>
      </div>
    </div>
</div>


    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['piechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([
          ['Sunday', 3],
          ['Monday', 1],
          ['Tuesday', 1],
          ['wednesday', 1],
          ['Thursday', 2],
          ['Friday', 2],
          ['Saturday', 2],

        ]);

        // Set chart options
        var options = {'title':'Per day booking for this week',
                       'width':480,
                       'height':250};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
@endsection
