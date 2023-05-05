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
        <x-s-e-o :seo=$location />

      </div>

    </form>
@endsection
