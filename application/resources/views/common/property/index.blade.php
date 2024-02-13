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
                            City
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
                            <td>
                                {{ $property->name }}
                            </td>
                            <td>
                                <a href="{{ getImageUrl($property->thumbnail) }}" target="_blank">
                               <img src="{{ getImageUrl($property->thumbnail) }}" alt="{{ $property->name }}" width="100" height="100">

                                </a>
                            </td>
                            <td>
                                {{ $property->city->name }}
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
                                            <a href="{{ route('admin.properties.edit', $property) }}"
                                            class="text-dark dropdown-item">Edit</a>
                                            <a href="#"
                                                    class="text-dark dropdown-item change_status" data-bs-toggle="modal"
                                                    data-userId="{{$property->id}}"
                                                    data-bs-target="#changeStatusModal">Delete</a>
                                            <a href="{{ route('admin.rooms.index', ['property_id'=>$property->id]) }}"
                                                class="text-dark dropdown-item">Manage Room</a>
                                        </div>
                                    </li>
                                    </ul>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{$properties->links()}}
    </div>
@endsection
