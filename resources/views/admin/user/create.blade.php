@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Create User</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
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
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.users.index') }}">Cancel</a>
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Name </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required value="{{old('name')}}"
                        name="name">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Email </label>
                    <input type="email" class="form-control" id="exampleInputUsername1"
                        name="email" value="{{old('email')}}">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Phone number </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"
                    value="{{old('phone_number')}}" required name="phone_number">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Role</label>
                    <select name="role" id="" class="form-control form-select" required>
                        <option value="">--select role--</option>
                        <option value="1">Customer</option>
                        <option value="2" >Agent</option>
                        <option value="3" >Partner</option>
                        <option value="4" >Seo Expert</option>
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
