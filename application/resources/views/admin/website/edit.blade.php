@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit website setting</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.websites.update',$website?$website:1) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-md-8">
              <div class="card">
                <div class="card-body">
 
                <div class="card-title d-flex justify-content-between">
                    <div>
                        Edit Cms
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.websites.edit',1) }}">Cancel</a>
                    </div>
                </div>

              
                <div class="row">


                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Phone 1</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="phone1" value="{{old('phone1',$website?$website->phone1:'')}}">
                </div>
                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Phone 2</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="phone2" value="{{old('phone2',$website?$website->phone2:'')}}">
                </div>

                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Email 1</label>
                    <input type="email" class="form-control" id="exampleInputUsername1"  
                        name="email1" value="{{old('email1',$website?$website->email1:'')}}">
                </div>



                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Email 2</label>
                    <input type="email" class="form-control" id="exampleInputUsername1"  
                        name="email2" value="{{old('email2',$website?$website->email2:'')}}">
                </div>
                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Address 1</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="address1" value="{{old('address1',$website?$website->address1:'')}}">
                </div>


                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Address 2</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="address2" value="{{old('address2',$website?$website->address2:'')}}">
                </div>

                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Facebook</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="facebook" value="{{old('facebook',$website?$website->facebook:'')}}">
                </div>


                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Linkedin</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="linkedin" value="{{old('linkedin',$website?$website->linkedin:'')}}">
                </div>


                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Instagram</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="instagram" value="{{old('instagram',$website?$website->instagram:'')}}">
                </div>

                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Tiktok</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="tiktok" value="{{old('tiktok',$website?$website->tiktok:'')}}">
                </div>


                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Playstore Link</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="playstore" value="{{old('playstore',$website?$website->playstore:'')}}">
                </div>

                <div class="form-group col-md-6"> 
                    <label for="exampleInputUsername1">Appstore Link</label>
                    <input type="text" class="form-control" id="exampleInputUsername1"  
                        name="appstore" value="{{old('appstore',$website?$website->appstore:'')}}">
                </div>




      
                <div class="form-group col-md-6">
                  <label for="exampleInputUsername1">Logo</label>
                  <br> 
                  <img id="preview_thumb" src="{{getImage($website->logo)}}" width="100" height="100" >
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="thumb" name="logo" >
                    <label class="custom-file-label" for="thumb">Choose file</label>
                  </div>
              </div>

              <div class="form-group col-md-6">
                <label for="exampleInputUsername1">Mobile Thumbnail</label>
                <br> 
                <img id="mobile_thumbnail_preview" src="{{getImage($website->fev)}}" width="100" height="100" >
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="mobile_thumbnail" name="fev" >
                  <label class="custom-file-label" for="mobile_thumbnail">Choose file</label>
                </div>
            </div>

              </div>

            </div>
          </div>
        </div>
        <x-s-e-o :seo=$website/>

      </div>

    </form>
@endsection
