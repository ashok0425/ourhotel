@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit City</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.cities.update',$city) }}" enctype="multipart/form-data">
      @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter City Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.cities.index') }}">Cancel</a>
                    </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Select State</label>
                  <select name="state" id="" class="form-select form-control" required>
                       <option value="0">--select state--</option>
                       @foreach ($states as $state)
                      <option value="{{$state->id}}" @if ($state->id==$city->state_id)
                          selected
                      @endif>{{$state->name}}</option>
                       @endforeach
                  </select>
              </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">City Name</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" required
                        name="name" value="{{$city->name}}">
                </div>

                <div class="form-group">
                  <label for="exampleInputUsername1">Thumbnail</label>
                  <br>
                  <img id="preview_thumb" src="{{getImageUrl($city->thumbnail)}}" width="100" height="100" >
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumb" name="thumbnail">
                    <label class="custom-file-label" for="thumb">Choose file</label>
                  </div>
              </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select name="status" id="" class="form-select form-control">
                        <option value="1" @if ($city->status==1)
                            selected
                        @endif>Active</option>
                        <option value="0" @if ($city->status==0)
                          selected
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>
          </div>
        </div>
        <x-s-e-o :seo=$city />
      </div>

    </form>
@endsection
