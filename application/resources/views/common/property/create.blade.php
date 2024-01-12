@extends('admin.layout.master')
@push('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Create New Property</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Property Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.properties.index') }}">Cancel</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Property Name</label>
                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" required
                                name="name" value="{{old('name')}}">
                        </div>
                          </div>
                    <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Select Partner</label>
                          <select name="partner" id="" class="form-select form-control" required>
                               <option value="">--select select partner--</option>
                               @foreach ($partners as $partner)
                              <option value="{{$partner->id}}" @if (old('partner')==$partner->id)
                                  selected
                              @endif>{{$partner->name}}</option>
                               @endforeach
                          </select>
                      </div>
                          </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select  Type</label>
                      <select name="propertyType" id="" class="form-select form-control" required>
                           <option value="">--select propertyType--</option>
                           @foreach ($propertyTypes as $propertyType)
                          <option value="{{$propertyType->id}}"
                            @if (old('propertyType')==$propertyType->id)
                            selected
                        @endif>{{$propertyType->name}}</option>
                           @endforeach
                      </select>
                  </div>
                      </div>


                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Select Category</label>
                          <select name="partner" id="" class="form-select form-control" required>
                               <option value="">--select category--</option>
                               @foreach ($categories as $category)
                              <option value="{{$category->id}}" @if (old('category')==$category->id)
                                  selected
                              @endif>{{$category->name}}</option>
                               @endforeach
                          </select>
                      </div>
                          </div>


                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputUsername1">Price Range</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="1000-5000" required
                            name="price_range" value="{{old('price_range')}}">
                    </div>
                      </div>


                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="exampleInputEmail1">Select Amenities </label>
                                      <select name="amenity[]" id="amenities" class="form-select form-control" required multiple>
                                           @foreach ($amenities as $amenity)
                                          <option value="{{$amenity->id}}"
                                             @if (in_array($amenity->id,old('amenity',[])))
                                              selected
                                          @endif>{{$amenity->name}}</option>
                                           @endforeach
                                      </select>
                                  </div>
                                      </div>

                  <div class="col-md-6">
                <div class="form-group">
                  <label for="exampleInputUsername1">Thumbnail</label>
                  <br>
                  <img id="preview_thumb" src="https://via.placeholder.com/120x150?text=thumbnail" width="100" height="100" class="d-none">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumb" name="thumbnail" required>
                    <label class="custom-file-label" for="thumb">Choose file</label>
                  </div>
              </div>
                  </div>
                  <div class="col-md-6">
                    <label>Gallery (Max 3 File)</label>
                    <div id="gallery_preview" class="d-flex">

                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gallery" >
                        <label class="custom-file-label" for="gallery">Choose file</label>
                      </div>

                      <small class="text-danger max_file">
                      </small>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Status</label>
                        <select name="status" id="" class="form-select form-control">
                            <option value="1"
                            @if (old('status')==1)
                                selected
                            @endif>Active</option>
                            <option value="0"
                             @if (old('status')==0)
                                selected
                            @endif>Inactive</option>
                        </select>
                    </div>
                      </div>




                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select State</label>
                      <select name="state" id="state" class="form-select form-control" required>
                           <option value="">--select State--</option>
                           @foreach ($states as $state)
                          <option value="{{$state->id}}" @if (old('state')==$state->id)
                              selected
                          @endif>{{$state->name}}</option>
                           @endforeach
                      </select>
                  </div>
                      </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Select City</label>
                      <select name="city" id="" class="form-select form-control" required>
                           <option value="">--select city--</option>
                           @foreach ($cities as $city)
                          <option value="{{$city->id}}" @if (old('city')==$city->id)
                              selected
                          @endif>{{$city->name}}</option>
                           @endforeach
                      </select>
                  </div>
                      </div>


                      <div class="col-md-12">
                        <div class="form-group">
                            <label for="exampleInputUsername1">Address </label>
                            <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Enter Address" required
                                name="address" value="{{old('address')}}">
                        </div>
                          </div>



                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputUsername1">Latitude</label>
                                <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Latitude" required
                                    name="latitude" value="{{old('latitude')}}">
                            </div>
                              </div>

                              <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Longitude</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Longitude" required
                                        name="longitude" value="{{old('longitude')}}">
                                </div>
                                  </div>



                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Description</label>
                          <textarea name="description" id="" class="form-control" rows="2">
                            {{old('description')}}
                          </textarea>
                        </div>
                      </div>

                  <div class="col-md-12">
                    <div class="form-group pt-4 d-flex justify-content-between">
                        <label> <input type="checkbox" name="top_rated" value='1'
                         @if (old('top_rated')==1)
                             checked
                         @endif > Top Rated</label>

                        <label> <input type="checkbox" name="pet_friendly" value='1'
                          @if (old('pet_friendly')==1)
                          checked
                      @endif> Pet Friendly</label>

                        <label> <input type="checkbox" name="couple_friendly" value='1'
                          @if (old('couple_friendly')==1)
                          checked
                      @endif> Couple Friendly </label>

                    </div>
                      </div>


            </div>
          </div>
        </div>
      </div>

      <x-s-e-o/>
      </div>

    </form>
@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
      // Basic
$("#amenities").select2({
  placeholder: "Select Amenities",
    allowClear: true
});

//ajax call to get cities
$('#state').change(function(){
    let stateId=$(this).val();
    let url =`/getCity/${stateId}`
    $.ajax({
    url:url,
    success:function(res){
        console.log(res);
    }
})
})
    </script>
@endpush
