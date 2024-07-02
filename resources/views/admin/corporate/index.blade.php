@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Corporates List
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
                            Company Name
                        </th>
                        <th>
                            Action
                        </th>


                    </tr>
                </thead>
                <tbody>
                    @foreach ($corporates as $corporate)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $corporate->name }}
                            </td>
                            <td>
                                {{ $corporate->company_name }}
                            </td>

                            <td>
                                <a href="{{ route('admin.corporates.edit', $corporate) }}" class="btn btn-primary btn-sm">Edit</a>

                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
