@extends('admin.layout.master')

@push('style')
</style>
@endpush
@section('content')
<div class="card">

    <div class="card-body table-responsive pt-3">
        <div class="card-title d-flex justify-content-between">
            <div>
                Booking Detail ({{$booking->booking_id}})
            </div>
            <div>
                <a href="{{route('bookings.edit',$booking)}}" class="btb btn btn-primary rounded-0">Download Invoice</a>

            </div>

        </div>

    </div>
</div>
        <div class="row mt-2">

<div class="col-md-6">
<div class="card">
    <div class="card-header">
        <h6>Customer Detail</h6>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <td>
                    Name
                </td>
                <td>
                    {{$booking->user?->name}}
                </td>
            </tr>
            <tr>
                <td>
                    Email
                </td>
                <td>
                    {{$booking->user?->email}}
                </td>
            </tr>
            <tr>

             <td>
                    Phone
                </td>
                <td>
                    {{$booking->phone_number}}
                </td>
            </tr>
            <tr>

                <td>
                    Booked By
                </td>
                <td>
                    {{$booking->user_id?$booking->user?->name:$booking->bookedBy->name}}
                </td>
            </tr>
        </table>
    </div>
</div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h6>Hotel Detail</h6>
            </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <td>
                        Name
                    </td>
                    <td>
                        {{$booking->property->owner?->name??$booking->hotel_data['name']??null}}
                    </td>
                </tr>
                <tr>
                    <td>
                        Phone
                    </td>
                    <td>
                        {{$booking->property?->owner?->phone_number??$booking->hotel_data['phone_number']??null}}
                    </td>
                </tr>

                <tr>
                    <td>
                        Address
                    </td>
                    <td>
                        {{$booking->property?->address??$booking->hotel_data['address']??null}}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    </div>

    <div class="col-md-12 mt-2">
        <div class="card">
            <div class="card-header">
<h6>Booking Detail</h6>

            </div>
            <div class="card-body mt-3">


<table  class="table">
<tr>
    <td>Status</td>
    <td class="text-wrap">
        @if ($booking->status == 0)
        <span class="badge bg-danger text-white">Cancelled</span>
    @endif
    @if ($booking->status == 1)
        <span class="badge bg-success text-white">Approved</span>
    @endif

    @if ($booking->status == 2)
        <span class="badge bg-info text-white">Upcoming</span>
        @endif
    </td>
</tr>
<tr>
    <td>Booking Type</td>
    <td class="text-wrap">
        {{$booking->booking_type}}
    </td>
</tr>
<tr>
    <td>Room Type</td>
    <td class="text-wrap">
        {{$booking->room_type}}
    </td>
</tr>
<tr>
    <td>CheckIn</td>
    <td class="text-wrap">
        {{$booking->booking_start}}
    </td>
</tr>

<tr>
    <td>Checkout</td>
    <td class="text-wrap">
        {{$booking->booking_end}}
    </td>
</tr>



<tr>
    <td>No of Room</td>
    <td class="text-wrap">
        {{$booking->no_of_room}}
    </td>
</tr>
<tr>
    <td>No of Adult</td>
    <td class="text-wrap">
        {{$booking->no_of_adult}}
    </td>
</tr>
<tr>
    <td>No of Child</td>
    <td class="text-wrap">
        {{$booking->no_of_child}}
    </td>
</tr>


@if ($booking->is_hourly_booked==1)
<tr>
    <td>
       Hourly Booked
    </td>
    <td>
            {{Carbon\Carbon::parse($booking->booked_hour_from)->format('G:i:A')}} -{{Carbon\Carbon::parse($booking->booked_hour_to)->format('G:i:A')}}
    </td>
</tr>
@else
<tr>
    <td>
       No. of Night
    </td>
    <td>
            {{$booking->no_of_night}}
    </td>
</tr>
@endif

<tr>
    <td>SubTotal</td>
    <td>{{$booking->total_price}}</td>
</tr>
<tr>
    <td>Tax</td>
    <td>{{$booking->tax}}</td>
</tr>
@if ($booking->discount)

<tr>
    <td>Discount</td>
    <td>{{$booking->discount}}</td>
</tr>
@endif
<tr>
<td>Final Total</td>
<td>{{$booking->final_amount}}</td>
</tr>
<tr>
<td>Payment Type</td>
<td>{{$booking->payment_type}}</td>
</tr>

<tr>
<td>Payment status</td>
<td>{{$booking->ispaid?'Paid':'Unpaid'}}</td>
</tr>
</table>
</div>


</div>
</div>
</div>

@endsection
