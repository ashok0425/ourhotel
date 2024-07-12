<tr>
    <td>{{$booking->booking_id}}
    <div>
        @if ($booking->status==0)
        <a  class="badge  bg-danger text-white">Cancelled</a>
        @elseif ($booking->status==1)
        <a  class="badge bg-success text-white">Completed</a>
        @elseif ($booking->status==2)
        <a  class="badge bg-info text-white">upcoming</a>
        @endif
    </div>
    </td>
    <td>{{Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y')}}  - {{Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y')}}</td>
    <td>
        @if ($booking->property)
        <a href="{{route('place_detail',['slug'=> $booking->property->slug?:''??$booking['place']['name']??'']) }}"> {{ $booking->property->name?:''??$booking['place']['name']??'' }} </a>
        @else
         <a href=""> {{ $booking->property?$booking->property->name?:''??$booking['place']['name']??'':'Deleted' }} </a>
        @endif

        <br>
        <small>{{Str::limit($booking->property?->address,50)??null}}</small>
    </td>
    <td>{{$booking->no_of_adult}}</td>
    <td>{{$booking->no_of_room}}</td>
    <td>{{$booking->payment_type}} <br> {!!$booking->is_paid?'<span class="badge bg-success text-white">paid</span>':'<span class="badge bg-danger text-white">unpaid</span>'!!}</td>
    <td>
<div class="btn-group">

    <a href="{{route('recipt',['uuid'=>$booking->uuid])}}" class="btn btn-sm btn-info " target="_blank" id="{{$booking->id}}"><i class="fas fa-eye"></i></a>
    @if ($booking->status==2&&$booking->status!=1)
    <a class="btn btn-sm bg-warning text-white"data-toggle="modal" data-target="#bookingCancelModal" id="writereviewBtn" data-id="{{$booking->id}}"><small>Cancel</small></a>
    @endif
    @if ($booking->property_id && $booking->status==1)
    <a  class="btn btn-sm bg-primary text-white" data-toggle="modal" data-target="#writereviewModal" id="writereviewBtn" data-id="{{$booking->property_id}}"><small>Feedback</small></a>
    @endif
</div>


  </td>

  </tr>


