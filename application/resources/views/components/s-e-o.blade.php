
<div class="col-md-4">
    <div class="card">
      <div class="card-body">
      <div class="card-title d-flex justify-content-between">
          <div>
              SEO (Optional)
          </div>
      </div>
      <div class="form-group">
          <label for="exampleInputUsername1">Meta Title For Desktop</label>
          <input type="text" class="form-control" id="exampleInputUsername1"
              placeholder="Enter meta title for desktop" name="meta_title"
              value="{{old('meta_title',$seo->meta_title)}}"
              >
      </div>

      <div class="form-group">
        <label for="exampleInputUsername1">Meta Keyword For Desktop</label>
        <input type="text" class="form-control" id="exampleInputUsername1"
            placeholder="Enter meta keyword for desktop" name="meta_keyword"
            value="{{old('meta_keyword',$seo->meta_keyword)}}"
            >
    </div>

    <div class="form-group">
      <label for="exampleInputUsername1">Meta Description For Desktop</label>
      <input type="text" class="form-control" id="exampleInputUsername1"
          placeholder="Enter meta description for desktop" name="meta_description"
          value="{{old('meta_description',$seo->meta_description)}}"
          
          >
  </div>

  <div class="form-group">
    <label for="exampleInputUsername1">Meta Title For Mobile</label>
    <input type="text" class="form-control" id="exampleInputUsername1"
        placeholder="Enter meta title for mobile" name="mobile_meta_title"
        value="{{old('mobile_meta_title',$seo->mobile_meta_title)}}"
        >
</div>

<div class="form-group">
  <label for="exampleInputUsername1">Meta Keyword For Mobile</label>
  <input type="text" class="form-control" id="exampleInputUsername1"
      placeholder="Enter meta keyword for mobile" name="mobile_meta_keyword"
      value="{{old('mobile_meta_keyword',$seo->mobile_meta_keyword)}}"
      >
</div>


<div class="form-group">
<label for="exampleInputUsername1">Meta Description For Mobile</label>
<input type="text" class="form-control" id="exampleInputUsername1"
    placeholder="Enter meta description for mobile" name="mobile_meta_description"
    value="{{old('mobile_meta_description',$seo->mobile_meta_description)}}"
    >
</div>

      <div class="d-flex justify-content-end ">
        <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
        <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.states.index') }}">Cancel</a>
      </div>
  </div>
</div>


</div>