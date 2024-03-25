<tr>
    <td>{{$booking->booking_id}}</td>
    <td>{{formatDate($booking->booking_start, 'd/m/Y')}}  - {{formatDate($booking->booking_end, 'd/m/Y')}}</td>
    <td>{{ $booking['place']?$booking['place']['name']:'' }}</td>
    <td>{{$booking->numbber_of_adult}}</td>
    <td>{{$booking->number_of_room}}</td>
    <td>
      @if ($booking->status==0)
      <a  class="btn btn-sm btn-danger">Cancelled</a>
      @elseif ($booking->status==1)
      <a  class="btn btn-sm btn-success">Completed</a>
      @else 
      <a href="{{route('cancel_booking',['id'=>$booking->id])}}" class="btn btn-sm btn-danger">Cancel</a>
      @endif
    <a href="" class="btn btn-sm btn-info view_btn"  data-toggle="modal" data-target="#exampleModal" id="{{$booking->id}}"><i class="fas fa-eye"></i></a>

    <a href="{{route('recipt',['id'=>$booking->id])}}" class="btn btn-sm btn-danger " target="_blank" id="{{$booking->id}}"><i class="fas fa-print"></i></a>
  </td>


  </tr>