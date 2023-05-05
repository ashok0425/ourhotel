@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Create New Location</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.locations.store') }}">
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
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.cities.index') }}">Cancel</a>
                    </div>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Select City</label>
                  <select name="city" id="" class="form-select form-control" required>
                       <option value="0">--select city--</option>
                       @foreach ($cities as $city)
                      <option value="{{$city->id}}">{{$city->name}}</option>
                       @endforeach
                  </select>
              </div>

                <div class="form-group"> 
                    <label for="exampleInputUsername1">Location</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" required
                        name="name">
                </div>

                <div class="form-group"> 
                  <label for="exampleInputUsername1">Latitude</label>
                  <input type="text" class="form-control" id="exampleInputUsername1" placeholder="latitude" required
                      name="latitude">
              </div>


              <div class="form-group"> 
                <label for="exampleInputUsername1">Longitude</label>
                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="longitude" required
                    name="longitude">
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
        <x-s-e-o />

      </div>

    </form>
@endsection
