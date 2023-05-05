@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Properties List
                </div>
                <div>
                    <a href="{{ route('admin.properties.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
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
                                {{ $property->user->name }}
                            </td>
                            <td>
                                {{ $property->name }}
                            </td>
                            <td>
                               <img src="{{ getImage($property->thumbnail) }}" alt=" {{ $property->name }}" width="70" height="70">
                            </td>
                            <td>
                           {{$property->address}}
                             </td>
                            <td>
                                @if ($property->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.properties.edit', $property) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('admin.properties.destroy', $property) }}"
                                    class="btn btn-danger btn-sm delete_row" data-toggle="modal"
                                    data-target="#deleteModal">Delete</a>
                                    <br>
                                    <br>

                                    <a href="{{ route('admin.rooms.index', ['property_id'=>$property->id]) }}"
                                    class="btn btn-info btn-sm" >Manage Room</a>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
