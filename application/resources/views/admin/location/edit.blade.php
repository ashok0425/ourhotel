@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit Location</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.locations.update',$location) }}">
      @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">
 
                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Location Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.locations.index') }}">Cancel</a>
                    </div>
                </div>
                
                <div class="form-group">
                  <label for="exampleInputEmail1">Select City</label>
                  <select name="city" id="" class="form-select form-control" required>
                       <option value="0">--select city--</option>
                       @foreach ($cities as $city)
                      <option value="{{$city->id}}" @if ($city->id==$location->city_id)
                          selected
                      @endif>{{$city->name}}</option>
                       @endforeach
                  </select>
              </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Location</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" required
                        name="name" value="{{$location->name}}">
                </div>

                <div class="form-group"> 
                  <label for="exampleInputUsername1">Latitude</label>
                  <input type="text" class="form-control" id="exampleInputUsername1" placeholder="latitude" required
                      name="latitude" value="{{$location->latitude}}">
              </div>


              <div class="form-group"> 
                <label for="exampleInputUsername1">Longitude</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="longitude" required
                    name="longitude" value="{{$location->longitude}}">
            </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select name="status" id="" class="form-select form-control">
                        <option value="1" @if ($location->status==1)
                            selected
                        @endif>Active</option>
                        <option value="0" @if ($location->status==0)
                          selected
                        @endif>Inactive</option>
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
                        placeholder="Enter meta title for desktop" name="meta_title"  value="{{$city->meta_title}}">
                </div>

                <div class="form-group">
                  <label for="exampleInputUsername1">Meta Keyword For Desktop</label>
                  <input type="text" class="form-control" id="exampleInputUsername1"
                      placeholder="Enter meta keyword for desktop" name="meta_keyword" value="{{$city->meta_keyword}}">
              </div>

              <div class="form-group">
                <label for="exampleInputUsername1">Meta Description For Desktop</label>
                <input type="text" class="form-control" id="exampleInputUsername1"
                    placeholder="Enter meta description for desktop" name="meta_description" value="{{$city->meta_description}}">
            </div>

            <div class="form-group">
              <label for="exampleInputUsername1">Meta Title For Mobile</label>
              <input type="text" class="form-control" id="exampleInputUsername1"
                  placeholder="Enter meta title for mobile" name="mobile_meta_title" value="{{$city->mobile_meta_title}}">
          </div>

          <div class="form-group">
            <label for="exampleInputUsername1">Meta Keyword For Mobile</label>
            <input type="text" class="form-control" id="exampleInputUsername1"
                placeholder="Enter meta keyword for mobile" name="mobile_meta_keyword" value="{{$city->mobile_meta_keyword}}">
        </div>


        <div class="form-group">
          <label for="exampleInputUsername1">Meta Description For Mobile</label>
          <input type="text" class="form-control" id="exampleInputUsername1"
              placeholder="Enter meta description for mobile" name="mobile_meta_description" value="{{$city->mobile_meta_description}}">
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
