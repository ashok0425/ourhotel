@extends('admin.layout.master')

@section('content')
<div class="mb-3 align-items-center d-flex justify-content-end">
    <form action="" method="get" class="d-flex align-items-center">
        <div>
            <label for="">City</label>
            <select name="city" id="" class="form-select form-control">
                <option value="">All Citys</option>
                @foreach ($cities as $key => $city)
                <option value="{{$key}}" {{request()->query('city')==$key? 'selected':''}}>{{$city}}</option>
                 @endforeach
            </select>
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
                    Properties List
                </div>
                <div>
                    <a href="{{ route('properties.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
                            class="icon-plus menu-icon"></i> Add New</a>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Partner
                        </th>
                        <th>
                            Name
                        </th>
                        <th>
                            Thumbnail
                        </th>
                        <th>
                            Address
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
                    @foreach ($properties as $property)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $property->owner?->name }}
                                <br>
                                {{ $property->owner?->email }}
                                <br>
                                {{ $property->owner?->phone_number }}

                            </td>
                            <td style="max-width: 220px;" class="text-wrap">
                                <a href="{{route('place_detail',['slug'=>$property->slug])}}">{{ $property->name }}</a>
                            </td>
                            <td>
                                <a href="{{ getImageUrl($property->thumbnail) }}" target="_blank">
                               <img src="{{ getImageUrl($property->thumbnail) }}" alt="{{ $property->name }}" width="100" height="100">

                                </a>
                            </td>
                            <td style="max-width: 220px;" class="text-wrap">
                                {{ $property->address }}
                            </td>


                            <td>
                                @if ($property->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                @endif
                            </td>
                            <td>

                                <ul class="nav ">

                                    <li class="nav-item">
                                        <a class="nav-link text-dark dropdown-toggle" data-toggle="dropdown" href="#"
                                            role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h fa-2x"></i></a>
                                        <div class="dropdown-menu">
                                            <a href="{{ route('properties.edit', $property) }}"
                                            class="text-dark dropdown-item">Edit</a>
                                            {{-- <a href="#"
                                                    class="text-dark dropdown-item change_status" data-bs-toggle="modal"
                                                    data-userId="{{$property->id}}"
                                                    data-bs-target="#changeStatusModal">Delete</a> --}}
                                                    <a href="#"
                                                    class="text-dark dropdown-item">View</a>
                                                    <a href="{{ route('rooms.index', ['property_id'=>$property->id]) }}"
                                                        class="text-dark dropdown-item">Manage Room</a>
                                          @if (Auth::user()->is_admin||Auth::user()->is_agent)
                                          <a href="{{ route('booking.create', ['property_id'=>$property->id]) }}"
                                            class="text-dark dropdown-item">Add Booking</a>
                                          @endif

                                          <a href="" class="text-dark dropdown-item updateSatusBtn"
                                          data-toggle="modal" data-target="#updatestatus" data-property_id="{{$property->id}}">Change Status</a>
                                        </div>
                                    </li>
                                    </ul>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{$properties->withQuerystring()->links()}}
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

            <form action="{{route('property.status')}}" method="POST" id="updateSatusForm">
                @method('PATCH')
                @csrf
                <input type="hidden" id="property_id" name="property_id">
                @method('PATCH')
                @csrf
                <select name="status" id="" class="form-control form-select" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
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
        let bookingId=$(this).data('property_id');
     $('#property_id').val(bookingId)
    })
    </script>
@endpush
