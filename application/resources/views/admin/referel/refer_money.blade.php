@extends('admin.layout.master')
@section('content')
    <div class="card">

        <div class="card-body table-responsive pt-3">
            <div class="card-title d-flex justify-content-between">
                <div>
                   Referel Money
                </div>

            </div>
            <table class="table table-bordered w-100">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                           Date
                        </th>
                        <th>
                            User
                        </th>
                        <th>
                            Refer Type
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Is Used
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($referels as $referel)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">
                                {{ Carbon\Carbon::parse($referel->created_at)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="text-wrap" style="max-width: 200px;">
                                <div class="text-wrap">
                                <a href="{{route('users.show',$referel->user)}}">{{ $referel->user->name }}</a>
                                </div>
                            </td>

                            <td>
                                {{ $property->refer->referel_type==1?'JOIN':"SHARE" }}
                             </td>
                             <td>{{$referel->price}}</td>
                             <td>
                                {{ $property->refer->is_user?'Yes':'No' }}
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
