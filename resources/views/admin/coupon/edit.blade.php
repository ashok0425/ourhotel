@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit Offer Coupon</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.coupons.update',$coupon) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Coupon Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.coupons.index') }}">Cancel</a>
                    </div>
                </div>


                <div class="row">



                <div class="form-group col-md-6">
                  <label for="exampleInputUsername1">Name</label>
                  <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Enter coupon Title" required
                      name="name" value="{{old('name',$coupon->coupon_name)}}">
              </div>


            <div class="form-group col-md-6">
              <label for="exampleInputUsername1">Coupon Value in percent</label>
              <input type="number" class="form-control" id="exampleInputUsername1" placeholder="Enter coupon value" required
                  name="coupon_value" value="{{old('coupon_value',$coupon->coupon_percent)}}">
          </div>

          <div class="form-group col-md-6">
            <label for="exampleInputUsername1">Min Cart Value to apply the coupon</label>
            <input type="number" class="form-control" id="exampleInputUsername1" placeholder="Enter cart alue" required
                name="coupon_min" value="{{$coupon->coupon_min}}">
        </div>
          <div class="form-group col-md-6">
            <label for="exampleInputUsername1">Coupon Expire At</label>
            <input type="date" class="form-control" id="exampleInputUsername1" placeholder="Enter coupon value"
                name="expired_at" value="{{Carbon\Carbon::parse(old('expired_at',$coupon->expired_at))->format('m-d-Y')}}">
                {{Carbon\Carbon::parse(old('expired_at',$coupon->expired_at))->format('m/d/Y')}}
        </div>
                <div class="form-group col-md-6">
                  <label for="exampleInputUsername1">Thumbnail</label>
                  <br>
                  <img id="preview_thumb" src="{{getImageUrl($coupon->thumbnail)}}" width="100" height="100" >
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumb" name="thumbnail" >
                    <label class="custom-file-label" for="thumb">Choose file</label>
                  </div>
              </div>

              <div class="form-group col-md-6">
                <label for="exampleInputUsername1">Mobile Thumbnail</label>
                <br>
                <img id="mobile_thumbnail_preview" src="{{getImageUrl($coupon->mobile_thumbnail)}}" width="100" height="100" >
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="mobile_thumbnail" name="mobile_thumbnail" >
                  <label class="custom-file-label" for="mobile_thumbnail">Choose file</label>
                </div>
            </div>

            <div class="form-group col-md-6">
              <label for="exampleInputEmail1">Status</label>
              <select name="status" id="" class="form-select form-control">
                  <option value="1" @if ($coupon->status==1)
                      selected
                  @endif>Active</option>
                  <option value="0" @if ($coupon->status==0)
                    selected
                  @endif>Inactive</option>
              </select>
          </div>
              </div>

            </div>
          </div>
        </div>

      </div>

    </form>
@endsection
