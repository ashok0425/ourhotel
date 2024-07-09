@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Seo List
                </div>
                <div>
                    <a href="{{ route('seos.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
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
                            Page
                        </th>
                        <th>
                            Path
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($seos as $seo)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap">
                                {{ $seo->page }}
                            </td>

                            <td class="text-wrap">
                                {{ $seo->path }}
                            </td>

                            <td>
                                <a href="{{ route('seos.edit', $seo) }}" class="btn btn-primary btn-sm">Edit</a>
                                <a href="{{ route('seos.destroy', $seo) }}"
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
