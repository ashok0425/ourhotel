@extends('admin.layout.master')
@section('content')
    <div class="card">
        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                    @if ($type == 1)
                        Contact List
                    @endif
                    @if ($type == 2)
                        Become a partner Request List
                    @endif

                    @if ($type == 3)
                        Corporate List
                    @endif

                    @if ($type == 4)
                        Subscribe List
                    @endif

                </div>

            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Data
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enquries as $enqury)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                @if ($type==1)
                                Contact
                                @endif
                                @if ($type==2)
                                Become a partner
                                @endif

                                @if ($type==3)
                                Corporate
                                @endif

                                @if ($type==4)
                                Subscribe
                                @endif
                            </td>
                            <td>
                                @foreach ($enqury->data as $key => $item)
                                    @if ($key!='_token'&&$key!='_method')
                                    <div><strong>{{ ucfirst($key) }}</strong>: {{ $item }}</div>

                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
            {{ $enquries->links() }}
        </div>
    </div>
@endsection
