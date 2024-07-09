@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Add New Notification</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.fcms.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Fcm Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.fcms.index') }}">Cancel</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Title </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"
                        name="title">
                </div>

                <div class="form-group">
                    <label for="exampleInputUsername1">Body </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  name="body">
                </div>

            </div>
          </div>
        </div>
      </div>
    </form>
@endsection
