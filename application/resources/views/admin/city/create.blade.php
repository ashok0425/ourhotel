@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Create New City</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.cities.store') }}" enctype="multipart/form-data">
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
                      <option value="{{$state->id}}">{{$state->name}}</option>
                       @endforeach
                  </select>
              </div>

                <div class="form-group"> 
                    <label for="exampleInputUsername1">City Name</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" required
                        name="name">
                </div>

                <div class="form-group">
                  <label for="exampleInputUsername1">Thumbnail</label>
                  <br> 
                  <img id="preview_thumb" src="https://via.placeholder.com/120x150?text=thumbnail" width="100" height="100" class="d-none">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumb" name="thumbnail" required>
                    <label class="custom-file-label" for="thumb">Choose file</label>
                  </div>
              </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select name="status" id="" class="form-select form-control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>
          </div>
        </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                <div class="card-title d-flex justify-content-between">
                    <div>
                        SEO (Optional)
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Meta Title For Desktop</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"
                        placeholder="Enter meta title for desktop" name="meta_title">
                </div>

                <div class="form-group">
                  <label for="exampleInputUsername1">Meta Keyword For Desktop</label>
                  <input type="text" class="form-control" id="exampleInputUsername1"
                      placeholder="Enter meta keyword for desktop" name="meta_keyword">
              </div>

              <div class="form-group">
                <label for="exampleInputUsername1">Meta Description For Desktop</label>
                <input type="text" class="form-control" id="exampleInputUsername1"
                    placeholder="Enter meta description for desktop" name="meta_description">
            </div>

            <div class="form-group">
              <label for="exampleInputUsername1">Meta Title For Mobile</label>
              <input type="text" class="form-control" id="exampleInputUsername1"
                  placeholder="Enter meta title for mobile" name="mobile_meta_title">
          </div>

          <div class="form-group">
            <label for="exampleInputUsername1">Meta Keyword For Mobile</label>
            <input type="text" class="form-control" id="exampleInputUsername1"
                placeholder="Enter meta keyword for mobile" name="mobile_meta_keyword">
        </div>


        <div class="form-group">
          <label for="exampleInputUsername1">Meta Description For Mobile</label>
          <input type="text" class="form-control" id="exampleInputUsername1"
              placeholder="Enter meta description for mobile" name="mobile_meta_description">
      </div>


                <div class="d-flex justify-content-end ">
                  <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                  <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.states.index') }}">Cancel</a>
                </div>
            </div>
          </div>

          
        </div>
      </div>

    </form>
@endsection
