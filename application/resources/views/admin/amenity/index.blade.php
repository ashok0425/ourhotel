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
                                <img src="{{ getImageUrl($amenity->thumbnail) }}" alt=" {{ $amenity->name }}" width="70" height="70">
                             </td>
                            <td>
                                @if ($amenity->status == 1)
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
                                            <a href="{{ route('admin.amenities.edit', $amenity) }}"
                                            class="text-dark dropdown-item">Edit</a>
                                            <a href="{{ route('admin.amenities.destroy', $amenity) }}"
                                                    class="text-dark dropdown-item delete_row" data-toggle="modal"
                                                    data-target="#deleteModal">Delete</a>

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
@endsection
