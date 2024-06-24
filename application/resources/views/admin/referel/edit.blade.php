@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit Refer Price</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.refer_prices.update',$refer) }}" enctype="multipart/form-data">
      @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Refer Price Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.refer_prices.index') }}">Cancel</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Share Price</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="share price" required
                        name="share_price" value="{{$refer->share_price}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Join Price</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="join price" required
                        name="join_price" value="{{$refer->join_price}}">
                </div>

                <div class="form-group">
                    <label for="exampleInputUsername1">Refer Content</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="refer content" required
                        name="refer_content" value="{{$refer->refer_content}}">
                </div>

            </div>
          </div>
        </div>

      </div>

    </form>
@endsection
