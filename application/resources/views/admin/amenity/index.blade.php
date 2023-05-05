@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Amenities List
                </div>
                <div>
                    <a href="{{ route('admin.amenities.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
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
                            Name
                        </th>
                        <th>
                            Thumbnail
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
                    @foreach ($amenities as $amenity)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $amenity->name }}
                            </td>
                            <td>
                                <img src="{{ getImage($amenity->thumbnail) }}" alt=" {{ $amenity->name }}" width="70" height="70">
                             </td>
                            <td>
                                @if ($amenity->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.amenities.edit', $amenity) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('admin.amenities.destroy', $amenity) }}"
                                    class="btn btn-danger btn-sm delete_row" data-toggle="modal"
                                    data-target="#deleteModal">Delete</a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
