@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    Refer List
                </div>

            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>

                        <th>
                            Join Amount
                        </th>
                        <th>
                            Share Amount
                        </th>
                        <th>
                            Action
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($refers as $refer)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap">
                                {{ $refer->join_price }}
                            </td>

                            <td class="text-wrap">
                                {{ $refer->share_price }}
                            </td>

                            <td>
                                <a href="{{ route('admin.refer_prices.edit', $refer) }}" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
