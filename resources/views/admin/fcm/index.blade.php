@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Fcm List
                </div>
                <div>
                    <a href="{{ route('admin.fcms.create') }}" class="btn btn-primary btn-rounded btn-fw btn-sm"><i
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
                            Title
                        </th>

                        <th>
                            User Count
                        </th>
                        <th>
                            Notification Sent
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fcms as $fcm)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap">
                                {{ $fcm->body }}
                            </td>
                            <td class="text-wrap">
                                {{ $fcm->user_count }}
                            </td>

                            <td class="text-wrap">
                                {{ $fcm->success_count }}
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            </div>
            {{$fcms->links()}}
        </div>
    </div>
@endsection
