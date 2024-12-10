@extends('admin.layout.master')

@section('content')

            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between">
                        <div>
                        Add Booking
                        </div>
                    </div>
                        <form method="post" action="">
                            @csrf
                            <div class="row">

                            @if (!isset($property_id))
                            <div class="form-group col-md-6">
                                <label for="place_name">Hotel Name : *</label>
                                <input type="text" class="form-control" name="hotel_name" value=""
                                    placeholder="Enter Hotel name" autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Hotel Phone : *</label>
                                <input type="text" class="form-control" name="hotel_phone" value=""
                                    placeholder="Enter Hotel Phone number" autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Hotel Address : *</label>
                                <input type="text" class="form-control" name="hotel_address" value=""
                                    placeholder="Enter Hotel Address" autocomplete="off" required="">
                            </div>

                            @endif
                            <input type="hidden" name="property_id" value="{{$property_id}}">
                            <div class="form-group  col-md-6">
                                <label for="place_name">Name : *</label>
                                <input type="text" class="form-control" name="name" value=""
                                    placeholder="Name" autocomplete="off" required="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Email </label>
                                <input type="text" class="form-control" name="email" value=""
                                    placeholder="Email Address" autocomplete="off">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Phone : *</label>
                                <input type="number" class="form-control" name="phone" value="" placeholder="Phone"
                                    autocomplete="off" required="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Numbers of Rooms : *</label>
                                <input type="number" class="form-control" name="rooms" value=""
                                    placeholder="Numbers Of Rooms" autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Check In Date : *</label>
                                <input type="date" class="form-control" name="check_in" value=""
                                    placeholder="Numbers Of Rooms" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Check out Date : *</label>
                                <input type="date" class="form-control" name="check_out" value=""
                                    placeholder="Numbers Of Rooms" required="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Number of adult : *</label>
                                <input type="number" class="form-control" name="adult" value=""
                                    placeholder="Number of adult" autocomplete="off" required="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Number Of Children : *</label>
                                <input type="number" class="form-control" name="children" value=""
                                    placeholder="Number Of Children" autocomplete="off" required="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Price : *</label>
                                <input type="number" class="form-control" name="price" value="" placeholder="Price"
                                    autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="room_type">Room Type</label>
                                <input type="text" class="form-control" name="room_type" value="" placeholder="Deluxe,Classic"
                                    autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="booking_type">Booking Type : *</label>
                                <select name="booking_type" class="form-control" required id="booking_type">
                                    <option value="">--type--</option>
                                    <option value="0">Hourly</option>
                                    <option value="1">Night</option>
                                </select>
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Payment Type : *</label>
                                <select name="payment_type" class="form-control">
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
                            </div>


                            <div class="form-group col-12 text-right">

                                <input type="submit" class="btn btn-primary rounded-0" name="submit" value="Add Booking">
                            </div>
                        </div>

                        </form>
                </div>


    </div>
@endsection
