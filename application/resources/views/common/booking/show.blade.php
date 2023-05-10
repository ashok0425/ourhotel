<div style="height:100vh">
<div class="card p-3">
        <div class="card-title d-flex justify-content-between">Customer Detail  <a href="javascript:void(0)" class="closebtn text-dark" onclick="closeNav()">&times;</a></div>
    <div class="row border-bottom">
        <div class="col-md-6 col-6">
            <b> Name</b> 
           <p>
            <span>{{ucfirst($booking->name)}}</span>
           </p>
        </div>
        <div class="col-md-6 col-6">
            <b> Email</b> 
           <p>
            <span>{{ucfirst($booking->email)}}</span>
           </p>
        </div>
    
        <div class="col-md-6 col-6">
            <b>Phone</b> 
           <p>
            <span>{{ucfirst($booking->phone)}}</span>
           </p>
        </div>
    </div>
</div>

<div class="card p-3">
    <div class="card-title">Booking Detail</div>
<div class="row border-bottom">
    <div class="col-md-6 col-6">
        <b>Property</b> 
       <p>
        <span>{{ucfirst($booking->property->name)}}</span>
       </p>
    </div>
    <div class="col-md-6 col-6">
        <b>Property Address</b> 
       <p>
        <span>{{ucfirst($booking->property->address)}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>Room</b> 
       <p>
        <span>{{ucfirst($booking->room->name)}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>Check In / Check Out</b> 
       <p>
        {{Carbon\Carbon::parse($booking->check_in)->format('d/m/Y')}} ({{Carbon\Carbon::parse($booking->booked_hour_from)->format('G:i:A')}}) 
        <br>
        {{Carbon\Carbon::parse($booking->check_out)->format('d/m/Y')}}
        ({{Carbon\Carbon::parse($booking->booked_hour_to)->format('G:i:A')}})
       </p>
    </div>
    <div class="col-md-6 col-6">
        <b>No of Night</b> 
       <p>
        <span>2</span>
       </p>
    </div>
    <div class="col-md-6 col-6">
        <b>No of Room</b> 
       <p>
        <span>{{$booking->no_of_room}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>No of Adult</b> 
       <p>
        <span>{{$booking->no_of_adult}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>No of Children</b> 
       <p>
        <span>{{$booking->no_of_child}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>Sub Total</b> 
       <p>
        <span>{{$booking->sub_total}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>Discount</b> 
       <p>
        <span>{{$booking->discount}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>Final Total</b> 
       <p>
        <span>{{$booking->total_price}}</span>
       </p>
    </div>

    <div class="col-md-6 col-6">
        <b>Status</b> 
       <p>
        <span class="badge bg-success">Accepted</span>
       </p>
    </div>
   
</div>
</div>

</div>
