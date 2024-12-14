@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit Seo</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('seos.update',$seo) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                        name="page" value="{{$seo->page}}">
                </div>


                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Path </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required
                        name="path"  value="{{$seo->path}}">
                </div>

                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Keyword </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"
                        name="keyword"  value="{{$seo->keyword}}">
                </div>


                <div class="form-group col-md-6">
                    <label for="exampleInputUsername1">Title </label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  required
                        name="title"  value="{{$seo->title}}">
                </div>


                <div class="form-group col-md-12">
                    <label for="exampleInputUsername1">Description </label>
                    <input type="text" class="form-control" id="summernote"  required
                        name="description"  value="{{$seo->description}}">
                </div>


                <div class="form-group col-md-12">
                    <label for="footercontent">Footer Content</label>
                    <textarea type="text" class="form-control" id="editor"  required
                        name="content" >
                        {{$seo->content}}
                    </textarea>
                </div>

                <div class="form-group col-md-12">
                    <label for="faq">FAQ</label>
                    <textarea type="text" class="form-control" id="editor1"  required
                        name="faq">
                        {{$seo->faq}}
                    </textarea>
                </div>
            </div>
            </div>
          </div>
        </div>

      </div>

    </form>
@endsection
@push('script')
<script src="{{ asset('admin/vendors/ckeditor.js') }}"></script>

    <script>

ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });

            ClassicEditor
            .create(document.querySelector('#editor1'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
