@extends('admin.layout.master')

@push('style')
    </style>
@endpush
@section('content')
    <div class="mb-3 align-items-center d-flex justify-content-end">
        <form action="" method="get" class="align-items-center">
            <div class="row">
                <div class="col-md-2 col-6 mx-0 px-0">
                    <label for="">Status</label>
                    <select name="status" id="" class="form-select form-control rounded-0">
                        <option value="">Status</option>
                        <option value="0" {{ request()->query('status') == 0 ? 'selected' : '' }}>Cancelled</option>
                        <option value="1" {{ request()->query('status') == 1 ? 'selected' : '' }}>Completed</option>
                        <option value="2" {{ request()->query('status') == 2 ? 'selected' : '' }}>Upcoming</option>

                    </select>
                </div>
                <div class="col-md-2 col-6  mx-0 px-0">
                    <label for="">Search Keyword</label>
                    <input type="search" name="keyword" id="" class="form-control rounded-0"
                        value="{{ request()->query('keyword') }}" placeholder="Enter search keyword">
                </div>
                <div class="col-md-2 col-4  mx-0 px-0">
                    <label for="">From</label>
                    <input type="date" name="from" id="" class="form-control rounded-0"
                        value="{{ request()->query('from') ? Carbon\Carbon::parse(request()->query('from'))->format('Y-m-d') : '' }}">
                </div>
                <div class="col-md-2 col-4  mx-0 px-0">
                    <label for="">To</label>
                    <input type="date" name="to" id="" class="form-control rounded-0"
                        value="{{ request()->query('to') ? Carbon\Carbon::parse(request()->query('to'))->format('Y-m-d') : '' }}">
                </div>


                <div class="col-md-1 col-4  mx-0 px-0">
                    <div class="mt-1"></div>
                    <button class="btn btn-info rounded-0 mt-4">Search</button>
                </div>

            </div>
        </form>
    </div>

    <div class="card">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between align-items-center">
                <div>
                    Booking List
                </div>
             @if (Auth::user()->is_admin||Auth::user()->is_agent)
             <div>
                <a href="{{ route('booking.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm">Book Unlisted
                    Hotel</a>
            </div>
             @endif

            </div>
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Hotel
                        </th>
                        <th>
                            User Detail
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
                                @if ($booking->property_id == 0)
                                    {{ $booking->hotel_data['name'] ?? '' }}
                                @else
                                    {{ $booking->property ? $booking->property->name : 'Hotel Deleted' }}
                                @endif
                                <br>
                                {{ $booking->booking_id }}
                            </td>

                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">

                                    @if (Auth::user()->is_admin)
                                        BY: <a
                                            href="{{ $booking->user?route('admin.users.show', $booking->user):'' }}">{{ $booking->user ? $booking->user->name : 'User Deleted' }}</a>
                                    @else
                                        {{ $booking->user ? $booking->user->name : 'User Deleted' }}
                                    @endif

                                    <br>
                                    {{ $booking->name }}
                                    <br>
                                    {{ $booking->phone_number }}
                                </div>
                            </td>


                            <td>
                                Room Type: {{ $booking->room_type }}

                                <br>
                                Booking Type: {{ $booking->booking_type }}
                                <br>
                                No.of Adult: {{ $booking->no_of_adult }}
                                <br>
                                No.of Child: {{ $booking->no_of_child }}
                                <br>
                                No.of Room: {{ $booking->no_of_room }}
                            </td>
                            <td>
                                SubTotal: {{ $booking->total_price }}
                                <br>
                                Tax: + {{ $booking->tax }}
                                <br>
                                Discount: - {{ $booking->discount }}
                                <br>
                                Final Amount: {{ $booking->final_amount }}

                            </td>

                            <td>
                                {{-- ({{Carbon\Carbon::parse($booking->booked_hour_from)->format('G:i:A')}}) --}}
                                {{-- ({{Carbon\Carbon::parse($booking->booked_hour_to)->format('G:i:A')}}) --}}
                                {{ Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y') }}
                                <br>
                                {{ Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y') }}

                            </td>
                            <td>
                                @if ($booking->status == 2)
                                    <span class="badge bg-info text-white">upcoming</span>
                                @endif
                                @if ($booking->status == 1)
                                    <span class="badge bg-success text-white">Completed</span>
                                @endif

                                @if ($booking->status == 0)
                                    <span class="badge bg-danger text-white">Cancelled</span>
                                @endif
                                <br>
                                <div class="badge bg-warning text-white">{{ $booking->is_paid == 1 ? 'Paid' : 'Unpaid' }}</div>

                            </td>
                            <td style="max-width: 50px">
                                <ul class="nav ">

                                    <li class="nav-item">
                                        <a class="nav-link text-dark dropdown-toggle" data-toggle="dropdown" href="#"
                                            role="button" aria-haspopup="true" aria-expanded="false"><i
                                                class="fas fa-ellipsis-h fa-2x"></i></a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('bookings.edit', $booking) }}"
                                            class="text-dark dropdown-item">Edit</a>
                                            <a href="{{ route('bookings.show', $booking) }}"
                                                class="text-dark dropdown-item">View</a>
                                            <a href="{{ route('bookings.download', ['id'=>$booking->booking_id]) }}"
                                                class="text-dark dropdown-item">Download Invoice</a>
                                            <a href="" class="text-dark dropdown-item updateSatusBtn"
                                                data-toggle="modal" data-target="#updatestatus"
                                                data-booking_id="{{ $booking->id }}">Change Status</a>

                                        </div>
                                    </li>
                                </ul>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{ $bookings->withQueryString()->links() }}
    </div>



    <!-- Modal -->
    <div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="updatestatusLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updatestatusLabel">Update Booking status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  pb-2">

                    <form action="{{ route('bookings.status') }}" method="POST" id="updateSatusForm">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" id="booking_id" name="booking_id">
                        @method('PATCH')
                        @csrf
                        <select name="status" id="" class="form-control rounded-0 form-select" required>
                            <option value="2">Upcoming</option>
                            <option value="1">Completed</option>
                            <option value="0">Cancel</option>
                        </select>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary  btn-rounded"
                                data-dismiss="modal">Close</button>
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
        $(document).on('click', '.updateSatusBtn', function() {
            let bookingId = $(this).data('booking_id');
            $('#booking_id').val(bookingId)
        })
    </script>
@endpush
