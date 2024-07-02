@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit Amenity</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.amenities.update',$amenity) }}" enctype="multipart/form-data">
      @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Amenity Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.amenities.index') }}">Cancel</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Amenity Name</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name" required
                        name="name" value="{{$amenity->name}}">
                </div>

                <div class="form-group">
                  <label for="exampleInputUsername1">Thumbnail</label>
                  <br>
                  <img id="preview_thumb" src="{{getImageUrl($amenity->thumbnail)}}" width="100" height="100" >
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumb" name="thumbnail">
                    <label class="custom-file-label" for="thumb">Choose file</label>
                  </div>
              </div>

                <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select name="status" id="" class="form-select form-control">
                        <option value="1" @if ($amenity->status==1)
                            selected
                        @endif>Active</option>
                        <option value="0" @if ($amenity->status==0)
                          selected
                        @endif>Inactive</option>
                    </select>
                </div>
            </div>
          </div>
        </div>

      </div>

    </form>
@endsection
