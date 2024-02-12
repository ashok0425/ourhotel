@extends('admin.layout.master')
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h4><strong>Create New Room</strong></h4>
        </div>
    </div>


    <form class="forms-sample" method="POST" action="{{ route('admin.rooms.store', ['property_id' => $property_id]) }}"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <div class="card-title d-flex justify-content-between">
                            <div>
                                Enter Room Detail
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                                <a class="btn btn-secondary  btn-rounded"
                                    href="{{ route('admin.rooms.index', ['property_id' => $property_id]) }}">Cancel</a>
                            </div>
                        </div>

                        <div class="row">
                            @if (!isset($property_id))
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Select Property</label>
                              <select name="property_id" id="" class="form-control form-select">
                                <option value="" >--select poperty--</option>
                                @foreach ($properties as $property)
                                <option value="{{$property->id}}" >{{$property->name}}</option>

                                @endforeach
                              </select>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Room</label>
                                    <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Name"
                                        required name="name" value="{{ old('name') }}">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">No of Such Room</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1"
                                        placeholder="No of Room" required name="no_of_room" value="{{ old('no_of_room') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">One Person Price</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1"
                                        placeholder="One Person Price" required name="onepersonprice"
                                        value="{{ old('onepersonprice') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Two Person Price</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1"
                                        placeholder="Two Person Price" name="twopersonprice"
                                        value="{{ old('twopersonprice') }}">
                                </div>
                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Three Person Price</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1"
                                        placeholder="Three Person Price" name="threepersonprice"
                                        value="{{ old('threepersonprice') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Hourly Price</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1"
                                        placeholder="Hourly price" required name="hourlyprice"
                                        value="{{ old('hourlyprice') }}">
                                    <small class="text-primary">Hourly Price means 3 hrs price</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Discount percent (optional)</label>
                                    <input type="number" class="form-control" id="exampleInputUsername1"
                                        placeholder="Discount percentage" name="discount_percent"
                                        value="{{ old('discount_percent') }}">
                                    <small class="text-primary">It must be in percent and will be applied for all price
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Select Amenities </label>
                                    <select name="amenity[]" id="amenities" class="form-select form-control" required
                                        multiple>
                                        @foreach ($amenities as $amenity)
                                            <option value="{{ $amenity->id }}"
                                                @if (in_array($amenity->id, old('amenity', []))) selected @endif>{{ $amenity->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputUsername1">Thumbnail</label>
                                    <br>
                                    <img id="preview_thumb" src="https://via.placeholder.com/120x150?text=thumbnail"
                                        width="100" height="100" class="d-none">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="thumb" name="thumbnail"
                                            required>
                                        <label class="custom-file-label" for="thumb">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Gallery (Max 3 File) </label>
                                <div id="gallery_preview" class="d-flex">

                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="gallery">
                                    <label class="custom-file-label" for="gallery">Choose file</label>
                                </div>

                                <small class="text-danger max_file"></small>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Status</label>
                                    <select name="status" id="" class="form-select form-control">
                                        <option value="1" @if (old('status') == 1) selected @endif>Active
                                        </option>
                                        <option value="0" @if (old('status') == 0) selected @endif>Inactive
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex justify-content-between">
                            <div>
                                <label class="d-flex align-items-center"> <input type="checkbox" value="1"
                                        name="has_monthy_price" id="has_monthy_price"
                                        style="height:20px!important;width:20px"> &nbsp; Month wise price variation</label>
                            </div>
                        </div>
                        <div
                            class="row has_monthy_price_show  @if (old('has_monthy_price') == 1) d-block @else d-none @endif">

                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month January</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price jan" name="jan"
                                    value="{{ old('jan', isset($room) ? $room->jan : '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month February</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price Feb" name="feb"
                                    value="{{ old('feb', isset($room) ? $room->feb : '') }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month March</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price March" name="march"
                                    value="{{ old('march', isset($room) ? $room->march : '') }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month April</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price April" name="april"
                                    value="{{ old('april', isset($room) ? $room->april : '') }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month June</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price Jun" name="jun"
                                    value="{{ old('jun', isset($room) ? $room->jun : '') }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month july</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price July" name="july"
                                    value="{{ old('july', isset($room) ? $room->july : '') }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month January</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price jan" name="jan"
                                    value="{{ old('jan', isset($room) ? $room->jan : '') }}">
                            </div>


                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month Augest</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price Augest" name="aug"
                                    value="{{ old('aug', isset($room) ? $room->aug : '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month September</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price Sept" name="sep"
                                    value="{{ old('sep', isset($room) ? $room->sep : '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month October</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price Oct" name="oct"
                                    value="{{ old('oct', isset($room) ? $room->oct : '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month November</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price Nov" name="nov"
                                    value="{{ old('nov', isset($room) ? $room->nov : '') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="exampleInputUsername1">Price for month December</label>
                                <input type="number" class="form-control" id="exampleInputUsername1"
                                    placeholder="Enter  price Dec" name="dec"
                                    value="{{ old('dec', isset($room) ? $room->dec : '') }}">
                            </div>

                        </div>



                        <div class="d-flex justify-content-end ">
                            <button type="submit" class="btn btn-primary mr-2 btn-rounded">Submit</button>
                        </div>
                    </div>
                </div>


            </div> --}}
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

        $('#has_monthy_price').click(function() {
            $('.has_monthy_price_show').toggleClass('d-none')
        })
    </script>
@endpush
