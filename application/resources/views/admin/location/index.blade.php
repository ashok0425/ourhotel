@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Locations List
                </div>
                <div>
                    <a href="{{ route('admin.locations.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
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
                            Latitude
                        </th>

                        <th>
                            Longitude
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
                    @foreach ($cities as $location)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $location->name }}
                            </td>
                            <td>
                                {{ $location->latitude }}
                            </td>

                            <td>
                                {{ $location->longitude }}
                            </td>
                            <td>
                                @if ($location->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('admin.locations.destroy', $location) }}"
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
