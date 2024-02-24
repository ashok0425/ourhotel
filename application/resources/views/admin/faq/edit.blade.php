@extends('admin.layout.master')
@section('content')
    <div class="card mb-3">
        <div class="card-body">
                    <h4><strong>Edit Faq</strong></h4>
            </div>
        </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.faqs.update',$faq) }}" enctype="multipart/form-data">
      @method('PATCH')
        @csrf
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                <div class="card-title d-flex justify-content-between">
                    <div>
                        Enter Faq Detail
                    </div>
                    <div>
                      <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                      <a class="btn btn-secondary  btn-rounded" href="{{ route('admin.faqs.index') }}">Cancel</a>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Question</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Question" required
                        name="question" value="{{$faq->question}}">
                </div>
                <div class="form-group">
                    <label for="exampleInputUsername1">Answer</label>
                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="answer" required
                        name="answer" value="{{$faq->answer}}">
                </div>


                <div class="form-group">
                    <label for="exampleInputUsername1">City </label>
                    <select name="city" id="" class="form-control form-select" required>
                        <option value="">--city--</option>
                    @foreach ($cities as $city)
                    <option value="{{$city->id}}" {{$city->id==$faq->city_id?'selected':''}}>{{$city->name}}</option>
                    @endforeach
                    </select>
                </div>


                <div class="form-group">
                    <label for="exampleInputEmail1">Status</label>
                    <select name="status" id="" class="form-select form-control">
                        <option value="1" @if ($faq->status==1)
                            selected
                        @endif>Active</option>
                        <option value="0" @if ($faq->status==0)
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
