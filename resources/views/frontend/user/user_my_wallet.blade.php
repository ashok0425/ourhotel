@extends('frontend.layouts.master')
@section('main')

    <div class="nsnhotelsbookinginformation container my-5 ">
        <div class="row">
            <div class="col-12  col-md-3 ">
                @include('frontend.user.sidebar')
            </div>

            <div class="col-12 8 col-md-9  ">
                <div class="row mt-30 mb-30 bg-white pb-4 ">
                    <div class="col">
                        <div class="referal-progress">
                            <h2 class="custom-fs-20 custom-fw-700 py-3">YOUR REFERAL MONEY</h2>
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>Total Earn money</td>
                                        <td><strong>₹ : {{ $total }}.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Total used money</td>
                                        <td><strong>₹ : {{ $used_money }}.00</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Wallet available</td>
                                        <td><strong>₹ : {{ $referl_money }}.00</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- copy code  --}}
                    <div class="col-12">
                        <h2 class="custom-fs-18 custom-fw-700 mb-2">Share the below Code or Link to make Referal Earning
                        </h2>
                    </div>

                    <div class="col-md-4 ">
                     <div class="d-flex">
						<input type="text" id="code" class="form-control w-50 custom-border-radius-0" value="{{ 'NSN' . Auth::id() }}" readonly>
						<button type="submit" class="btn custom-bg-primary custom-border-radius-0 copy-refer text-white w-40" onclick="myFunction1()">Copy Code</button>
					 </div>
				</div>

                <div class="col-md-8 mt-2 mt-md-0">
					<div class="d-flex">

					<input type="text" id="link" class="form-control w-75 custom-border-radius-0" value="{{ route('user_register',['q'=>'NSN' . Auth::id()])  }}" readonly>
					<button type="submit" class="btn custom-bg-primary custom-border-radius-0 w-25  text-white" onclick="myFunction2()">Copy Link</button>
					</div>
				</div>

				</div>

            </div>
        </div>

    </div>
    </div>
@stop
@push('scripts')
    <script>

 function myFunction1() {
  // Get the text field
  var copyText = document.getElementById("code");

  // Select the text field
  copyText.select();

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  toastr.success("Copied the text: " + copyText.value);
}


function myFunction2() {
  // Get the text field
  var copyText = document.getElementById("link");

  // Select the text field
  copyText.select();

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);

  // Alert the copied text
  toastr.success("Copied the text: " + copyText.value);
}
    </script>
@endpush
