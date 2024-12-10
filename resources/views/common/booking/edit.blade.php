@extends('admin.layout.master')

@section('content')

            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between">
                        <div>
                        Edit Booking
                        </div>
                    </div>
                    <form method="post" action="{{ route('bookings.update', $booking->id) }}">
                        @csrf
                        @method('PUT')
<div class="row">
                        <div class="form-group col-md-6">
                            <label for="name">Name: *</label>
                            <input type="text" class="form-control" name="name"
                                   value="{{ old('name', $booking->name) }}"
                                   placeholder="Name of Person" autocomplete="off" required="">
                        </div>

                        <div class="form-group  col-md-6">
                            <label for="place_name">Email </label>
                            <input type="text" class="form-control" name="email" value="{{$booking->email}}"
                                placeholder="Email Address" autocomplete="off">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="phone">Phone: *</label>
                            <input type="number" class="form-control" name="phone"
                                   value="{{ old('phone', $booking->phone_number) }}"
                                   placeholder="Phone" autocomplete="off" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="rooms">Numbers of Rooms: *</label>
                            <input type="number" class="form-control" name="rooms"
                                   value="{{ old('rooms', $booking->no_of_room) }}"
                                   placeholder="Numbers Of Rooms" autocomplete="off" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="check_in">Check In Date: *</label>
                            <input type="date" class="form-control" name="check_in"
                                   value="{{ old('check_in', $booking->booking_start) }}"
                                   required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="check_out">Check Out Date: *</label>
                            <input type="date" class="form-control" name="check_out"
                                   value="{{ old('check_out', $booking->booking_end) }}"
                                   required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="adult">Number of Adults: *</label>
                            <input type="number" class="form-control" name="adult"
                                   value="{{ old('adult', $booking->no_of_adult) }}"
                                   placeholder="Number of Adults" autocomplete="off" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="children">Number of Children: *</label>
                            <input type="number" class="form-control" name="children"
                                   value="{{ old('children', $booking->no_of_child) }}"
                                   placeholder="Number of Children" autocomplete="off" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="price">Price: *</label>
                            <input type="number" class="form-control" name="price"
                                   value="{{ old('price', $booking->final_amount) }}"
                                   placeholder="Price" autocomplete="off" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="room_type">Room Type: *</label>
                            <input type="text" class="form-control" name="room_type"
                                   value="{{ old('room_type', $booking->room_type) }}"
                                   placeholder="Deluxe, Classic" autocomplete="off" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="booking_type">Booking Type: *</label>
                            <select name="booking_type" class="form-control" required>
                                <option value="" disabled>--Select Type--</option>
                                <option value="0" {{ old('booking_type', $booking->booking_type) == 0 ? 'selected' : '' }}>Hourly</option>
                                <option value="1" {{ old('booking_type', $booking->booking_type) == 1 ? 'selected' : '' }}>Night</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_type">Payment Type: *</label>
                            <select name="payment_type" class="form-control" required>
                                <option value="online" {{ old('payment_type', $booking->payment_type) == 'online' ? 'selected' : '' }}>Online</option>
                                <option value="offline" {{ old('payment_type', $booking->payment_type) == 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                        </div>

                        <div class="form-group col-12 text-right">
                            <button type="submit" class="btn btn-primary rounded-0">Update Booking</button>
                        </div>
                    </div>
                    </form>

                </div>


    </div>
@endsection
