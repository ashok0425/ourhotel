@extends('admin.layout.master')
@section('content')
    <div class="card">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    User List
                </div>

            </div>
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                           Name
                        </th>
                        <th>
                            Email
                        </th>
                        <th>
                            Phone
                        </th>
                        <th>
                            Register No
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
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>

                            <td>
                           {{$user->phone}}
                             </td>
                             <td>
                                {{Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}

                                  </td>
                            <td>
                                @if ($user->status == 1)
                                    <span class="badge bg-success text-white">Active</span>
                                @else
                                    <span class="badge bg-danger text-white">Blocked</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary btn-sm">view</a>
                            </td>

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        {{$users->withQueryString()->links()}}
    </div>

@endsection

@push('script')

@endpush
