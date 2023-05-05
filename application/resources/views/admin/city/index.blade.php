@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Cities List
                </div>
                <div>
                    <a href="{{ route('admin.cities.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
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
                    @foreach ($cities as $city)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $city->name }}
                            </td>
                            <td>
                               <img src="{{ getImage($city->thumbnail) }}" alt=" {{ $city->name }}" width="70" height="70">
                            </td>
                            <td>
                                @if ($city->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.cities.edit', $city) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('admin.cities.destroy', $city) }}"
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
