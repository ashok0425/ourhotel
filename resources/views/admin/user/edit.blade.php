@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit User</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.users.update',$user) }}" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter User Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('seos.index') }}">Cancel</a>
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Name </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required value="{{old('name',$user->name)}}"
                        name="name">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Email </label>
                    <input type="email" class="form-control" id="exampleInputUsername1"
                        name="email" value="{{old('email',$user->email)}}">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Phone number </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"
                    value="{{old('phone_number',$user->phone_number)}}" required name="phone_number">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Role</label>
                    <select name="role" id="" class="form-control form-select" required>
                        <option value="">--select role--</option>
                        <option value="1">Customer</option>
                        <option value="2" {{$user->is_agent?'selected':''}}>Agent</option>
                        <option value="3" {{$user->is_partner?'selected':''}}>Partner</option>
                        <option value="4" {{$user->isSeoExpert?'selected':''}}>Seo Expert</option>
                        {{-- <option value="4" {{$user->is_admin?'selected':''}}>Admin</option> --}}

                    </select>
                </div>

            </div>
            </div>
          </div>
        </div>

      </div>

    </form>
@endsection
