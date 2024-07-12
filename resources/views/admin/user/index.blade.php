@extends('admin.layout.master')
@section('content')
<div class="mb-3 align-items-center d-flex justify-content-end">
    <form action="" method="get" class="d-flex align-items-center">

        <div>
            <label for="">Status</label>
            <select name="status" id="" class="form-select form-control">
                <option value="">Status</option>
                <option value="0" {{request()->query('status')==0? 'selected':''}}>Blocked</option>
                <option value="1" {{request()->query('status')==1? 'selected':''}}>Active</option>
            </select>
        </div>

        <div>
            <label for="">Register From</label>
            <input type="date" name="from" id="" class="form-control" value="{{request()->query('from')?Carbon\Carbon::parse( request()->query('from'))->format('Y-m-d') : ''}}">
        </div>
        <div>
            <label for="">Register To</label>
            <input type="date" name="to" id="" class="form-control" value="{{request()->query('to')?Carbon\Carbon::parse( request()->query('to'))->format('Y-m-d') : ''}}">
        </div>
        <div>
            <label for="">Search Keyword</label>
            <input type="search" name="keyword" id="" class="form-control" value="{{request()->query('keyword')}}" placeholder="Enter search keyword">
        </div>

        <div>
        <button class="btn btn-info rounded-0 mt-4">Search</button>
        </div>

    </form>
</div>
    <div class="card">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    User List
                </div>

            </div>
            <div class="table-responsive">
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                           Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Register No
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
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">
                                {{ $user->name }}
                                </div>
                            </td>
                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">
                                {{ $user->email }}
                                </div>
                            </td>

                            <td>
                           {{$user->phone_number}}
                             </td>
                             <td>
                                {{Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}

                                  </td>
                            <td>
                                @if ($user->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Blocked</span>
                                @endif
                            </td>
                            <td>
                                <ul class="nav ">

                                    <li class="nav-item">
                                        <a class="nav-link text-dark dropdown-toggle" data-toggle="dropdown" href="#"
                                            role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h fa-2x"></i></a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('admin.users.show', $user) }}" class="text-dark dropdown-item">View</a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-dark dropdown-item">Edit</a>
                                            <a href="" class="text-dark dropdown-item updateSatusBtn"
                                            data-toggle="modal" data-target="#updatestatus" data-booking_id="{{$user->id}}">Change Status</a>

                                        </div>
                                    </li>
                                    </ul>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
            </div>
        </div>
        {{$users->withQueryString()->links()}}
    </div>

      <!-- Modal -->
  <div class="modal fade" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="updatestatusLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updatestatusLabel">Update Booking status</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body  pb-2">

            <form action="{{route('admin.users.status')}}" method="POST" id="updateSatusForm">
                @method('PATCH')
                @csrf
                <input type="hidden" id="booking_id" name="user_id">
                @method('PATCH')
                @csrf
                <select name="status" id="" class="form-control form-select" required>
                    <option value="1">Active</option>
                    <option value="0">Block</option>
                </select>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary  btn-rounded" data-dismiss="modal">Close</button>
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
    $(document).on('click','.updateSatusBtn',function(){
        let bookingId=$(this).data('booking_id');
     $('#booking_id').val(bookingId)
    })
    </script>
@endpush
