@extends('admin.layout.master')
@section('content')

<div class="mb-3 align-items-center d-flex justify-content-end">
    <form action="" method="get" class="d-flex align-items-center">
        <input type="search" name="keyword" id="" class="form-control" value="{{request()->query('keyword')}}">
        <button class="btn btn-info rounded-0">Search</button>
    </form>
</div>
    <div class="card">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    State List
                </div>
                <div>
                    <a href="{{ route('admin.states.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
                            class="icon-plus menu-icon"></i> Add New</a>
                </div>
            </div>

            <div class="table-responsive">
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
                            Status
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($states as $state)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $state->name }}
                            </td>
                            <td>
                                @if ($state->status == 1)
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
                                            <a href="{{ route('admin.states.edit', $state) }}"
                                            class="text-dark dropdown-item">Edit</a>
                                            <a href="{{ route('admin.states.edit', $state) }}"
                                                    class="text-dark dropdown-item delete_row" data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal">Delete</a>

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
    </div>
@endsection
