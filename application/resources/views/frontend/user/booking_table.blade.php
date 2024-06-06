<tr>
    <td>{{$booking->booking_id}}</td>
    <td>{{Carbon\Carbon::parse($booking->booking_start)->format('d/m/Y')}}  - {{Carbon\Carbon::parse($booking->booking_end)->format('d/m/Y')}}</td>
    <td>{{ $booking['place']?$booking['place']['name']:'' }}</td>
    <td>{{$booking->numbber_of_adult}}</td>
    <td>{{$booking->number_of_room}}</td>
    <td>
      @if ($booking->status==0)
      <a  class="badge  bg-danger text-white">Cancelled</a>
      @elseif ($booking->status==1)
      <a  class="badge bg-success text-white">Completed</a>
      @else
      <a href="{{route('cancel_booking',['id'=>$booking->id])}}" class="btn btn-sm btn-danger">Cancel</a>
      @endif

    <a href="{{route('recipt',['uuid'=>$booking->uuid])}}" class="btn btn-sm btn-danger " target="_blank" id="{{$booking->id}}"><i class="fas fa-eye"></i></a>
  </td>


  </tr>
