@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit Blog</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.blogs.update',$blog) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Blog Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.blogs.index') }}">Cancel</a>
                    </div>
                </div>


                <div class="form-group ">
                    <label for="exampleInputUsername1">Title</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Blog Title" required
                        name="title" value="{{$blog->title}}">
                </div>

                {{-- <div class="form-group ">
                  <label for="exampleInputUsername1">Short Description</label>
                  <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Short Description" required
                      name="short_description" value="{{$blog->short_description}}">
              </div> --}}


              <div class="form-group ">
                <label for="exampleInputUsername1">Long Description</label>
                <textarea type="text" class="form-control" id="editor" placeholder="Long Description" required
                    name="long_description">{{$blog->long_description}}</textarea>
            </div>



                <div class="form-group ">
                  <label for="exampleInputUsername1">Thumbnail</label>
                  <br>
                  <img id="preview_thumb" src="{{getImageUrl($blog->thumbnail)}}" width="100" height="100" class="d-none">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumb" name="thumbnail" >
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
            <x-s-e-o :seo=$blog/>
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

</script>
@endpush
