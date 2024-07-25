@extends('admin.layout.master')

@section('content')

            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between">
                        <div>
                        Add Tour Booking
                        </div>
                    </div>
                        <form method="post" action="{{route('tour_bookings.store')}}">
                            @csrf
                            <div class="row">

                            <div class="form-group col-md-6">
                                <label for="place_name">Tour Name : *</label>
                                <input type="text" class="form-control" name="tour_name" value=""
                                    placeholder="Enter tour name" autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Name : *</label>
                                <input type="text" class="form-control" name="name" value=""
                                    placeholder=" Name of Person" autocomplete="off" required="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Phone : *</label>
                                <input type="number" class="form-control" name="phone" value="" placeholder="Phone"
                                    autocomplete="off" required="">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="place_name">Email : *</label>
                                <input type="email" class="form-control" name="email" value=""
                                    placeholder="Enter email address" autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Start Date : *</label>
                                <input type="date" class="form-control" name="check_in" value=""
                                 required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">End Date : *</label>
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
                                <label for="place_name">Total Amount : *</label>
                                <input type="number" class="form-control" name="price" value="" placeholder="Price"
                                    autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Paid Amount : *</label>
                                <input type="number" class="form-control" name="paid_price" value="" placeholder="Price"
                                    autocomplete="off" required="">
                            </div>

                            <div class="form-group  col-md-6">
                                <label for="place_name">Payment Type : *</label>
                                <select name="payment_type" class="form-control">
                                    <option value="online">Online</option>
                                    <option value="offline">Offline</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label for="">Remark</label>
                                <input type="text" name="remark" id="" class="form-control">
                            </div>


                            <div class="form-group col-12 text-right">

                                <input type="submit" class="btn btn-primary rounded-0" name="submit" value="Add Booking">
                            </div>
                        </div>

                        </form>
                </div>


    </div>
@endsection
