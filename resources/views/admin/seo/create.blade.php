@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Create New Seo</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('seos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Seo Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('seos.index') }}">Cancel</a>
                    </div>
                </div>
                <div class="row">
                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Page </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required
                        name="page">
                </div>


                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Path </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required
                        name="path">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Meta Keyword </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"
                        name="keyword">
                </div>


                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Meta Title </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required
                        name="title">
                </div>


                <div class="form-group col-md-12">
                    <label for="exampleInputUsername1">Meta Description </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required
                        name="description">
                </div>


                <div class="form-group col-md-12">
                    <label for="footercontent">Footer Content</label>
                    <textarea type="text" class="form-control" id="footercontent"  required
                        name="content">
                    </textarea>
                </div>

                <div class="form-group col-md-12">
                    <label for="faq">FAQ</label>
                    <textarea type="text" class="form-control" id="faq"  required
                        name="faq">
                    </textarea>
                </div>
            </div>
            </div>
          </div>
        </div>

      </div>

    </form>
@endsection
