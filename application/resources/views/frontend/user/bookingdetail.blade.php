@php
    $date1 = new DateTime($booking->booking_start);
$date2 = new DateTime($booking->booking_end);
$numberOfNights= $date2->diff($date1)->format("%a"); 
@endphp
<ul class="bookingpersondetails">
    <li>Booking ID<span>NSN{{$booking->id}}</span></li>
    <li>Booking Date<span>{{ formatDate($booking->created_at, 'd/m/Y') }}</span></li>
    <li>Check IN/OUT Date<span>{{formatDate($booking->booking_start, 'd/m/Y')}}  - {{formatDate($booking->booking_end, 'd/m/Y')}}</span></li>
    <li>Hotel Name<span>{{ $booking['place']['name'] }}</span></li>
    <li> No. of Guests<span>{{$booking->numbber_of_adult}}</span></li>
    <li>No. of Room<span>{{$booking->number_of_room}} </span></li>
    <li>No. of Nights <span>{{ $numberOfNights }} </span></li>
    <li>Mail<span>{{ $booking->email }}</span></li>
    <li>Phone<span>{{$booking->phone_number}}</span></li>
    <li class="inrsymbols">Booking Amount<span>{{number_format($booking->amount,0)}}</span></li> 
    @if($booking->payment_type =='offline')
    <li>Payment Mode<span>Pay at Hotel</span></li>
    @endif
    @if($booking->payment_type =='online')
    <li>Payment Mode<span>Online</span></li>
    @endif
</ul>