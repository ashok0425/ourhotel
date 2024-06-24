@extends('frontend.layouts.master')
@section('main')
<style>
    * {
	margin: 0px;
	padding: 0px;
	transition: all 0.5s ease 0s;
	-webkit-transition: all 0.5s ease 0s;
	-moz-transition: all 0.5s ease 0s;
	-ms-transition: all 0.5s ease 0s;
	-o-transition: all 0.5s ease 0s;
}
html, body, address, blockquote, div, dl, form, h1, h2, h3, h4, h5, h6, ol, p, pre, table, ul, dd, dt, li, tbody, td, tfoot, th, thead, tr, button, del, ins, map, object, a, abbr, acronym, b, bdo, big, br, cite, code, dfn, em, i, img, kbd, q, samp, small, span, strong, sub, sup, tt, var, legend, fieldset, p {
	margin: 0;
	padding: 0;
	border: none;
}
a, input, select, textarea {
	outline: none;
	margin: 0;
	padding: 0;
}
a:hover,focus{
	text-decoration:none;
	outline: none;
	border: none;
}
img, fieldset {
	border: 0;
}
a {
	outline: none;
	border: none;
}
img {
	max-width: 100%;
	height: auto;
	width: auto\9;
	vertical-align: middle;
	border: none;
	outline: none;
}
article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
	display: block;
	margin: 0;
	padding: 0;
}
div, h1, h2, h3, h4, span, p, input, form, img, hr, img, a {
	margin: 0;
	padding: 0;
	border: none;
}
.mt-30, .mb-30{margin: 30px 0;}
.clear {
	clear: both;
}
.share-boxes p {margin: 15px 0 0; font-size: 15px; font-weight: bold;}
.share-boxes {background: #f9f9f9; text-align: center; border-radius: 10px;  box-shadow: 0 0 17px #ccc;
    padding: 20px 0;  position: relative;}
.share-boxes img.dotted-line {position: absolute; left: -167px; top: 5px; transform: rotate(-3deg);}
.share-boxes img.dotted-line2 {position: absolute; right: -173px; top: 5px; transform: rotate(-4deg);}
.refer-image img {width: 100%;}
.refer-form ul li {float: left; list-style: none; width: 33.333%; text-align: center;}
.refer-form ul li a {background: #9fb0f8; display: block; padding: 14px; color: #fff; text-transform: uppercase;
    font-weight: 600;}
.refer-form ul {margin: 0;}
.refer-form ul li.facebook-color a{background: #9fb0f8}
.refer-form ul li.youtube-color a{background: #eb8c8c}
.refer-form ul li.twitter-color a{background: #9cd0fc}
.refer-form ul li.facebook-color a:hover{background: #4667f7; text-decoration: none;}
.refer-form ul li.youtube-color a:hover{background: #dd2020; text-decoration: none;}
.refer-form ul li.twitter-color a:hover{background: #40a7ff; text-decoration: none;}
.refer-form-content {float: left; width: 100%; background: #f9f9f9; padding: 30px; }
.refer-form-content h2 {color: #ffc3c9; font-weight: bold; text-transform: uppercase; font-size: 25px; margin: 0 0 10px; }
.refer-form-content P a {color: #ffc3c9; font-weight: 500; }
.refer-form-content input{height: 50px; width: 100%; padding: 15px; border-radius: 1px; margin-bottom: 20px; box-shadow: 0 0 6px #ccc; }
.container-checkbox {display: block; position: relative; padding-left: 30px; margin-bottom: 12px; cursor: pointer; font-size: 16px; -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none; }
.container-checkbox input {position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
.checkmark {position: absolute; top: 3px; left: 0; height: 20px; width: 20px; background-color: transparent; border: 2px solid #ffc3c9; }
.container-checkbox:hover input ~ .checkmark {background-color: #ccc; }
.container-checkbox input:checked ~ .checkmark {background-color: #ffc3c9; }
.checkmark:after {content: ""; position: absolute; display: none; }
.container-checkbox input:checked ~ .checkmark:after {display: block; }
.container-checkbox .checkmark:after {left: 5px; top: 0px; width: 7px; height: 12px; border: solid white; border-width: 0 3px 3px 0; -webkit-transform: rotate(45deg); -ms-transform: rotate(45deg); transform: rotate(45deg); }
.refer-form-content form button {background: #ffc3c9; color: #fff; font-weight: 500; font-size: 18px; width: 100%; height: 50px; cursor: pointer; }
.refer-form-content form button:hover{background: #000;}
.refer-form-content input::placeholder{color:#c5c5c5; font-size: 14px;}
.row.refer-form-sec {height: 580px; overflow: hidden; margin-top: 55px; }
.referal-progress table td:nth-child(2) {text-align: right; }
.referal-progress table td {border: 1px solid #cccc; padding: 15px 20px; }
.row.refer-form-sec .col:first-child {padding-right: 0; }
.row.refer-form-sec .col:last-child {padding-left: 0; }
.referal-progress h2 {color: #ffc3c9; font-size: 22px; margin: 10px 0 15px; }
.share-boxes:after {content: ""; background: url("https://i.ibb.co/WHdS3G1/circle.png") no-repeat 0 0; position: absolute; left: 0; right: 0; bottom: -65px; margin: 0 auto; z-index: 99999; height: 60px; width: 20px; }
@media only screen and (max-width: 1100px){
.share-boxes img.dotted-line, .share-boxes img.dotted-line2 {
    display: none;
}

}
@media only screen and (max-width: 767px){
.share-boxes {
    margin: 0 0 52px;
}
.row.refer-form-sec {
    height: auto;
    overflow: hidden;
    margin-top: 55px;
    display: block;
}
.row.refer-form-sec .col:first-child {
    padding-right: 15px;
    margin: 0 0 30px;
}
.row.refer-form-sec .col:last-child {
    padding-left: 15px;
}
}
@media only screen and (max-width: 380px){
.refer-form ul li a {
    padding: 9px;
    font-size: 14px;
}
.refer-form-content h2 {
    font-size: 22px;
}
}
</style>
  <!--<body>-->
    <div class="container">
        <div class="row mt-30 mb-30">
          <div class="col-sm-12 col-md-3">
            <div class="share-boxes">
              <img src="https://i.ibb.co/PtYrLNy/img1.png" alt="img1" border="0">
              <p>Share with your friends</p>
            </div>
          </div>
          <div class="col"></div>
          <div class="col-sm-12 col-md-3">
            <div class="share-boxes">
              <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4Fa-5hmp2YYVLrqz1q3yR9B9SQa17xGxzLw&usqp=CAU" alt="img2" border="0">
              <p>Give him/her to ₹ {{App\Models\ReferPrice::first()->join_price}} Discount</p>
              <img src="https://i.ibb.co/Sr5F70S/dotted-arrow1.png" alt="dotted-arrow1" class="dotted-line">
              <img src="https://i.ibb.co/Fqs2KxB/dotted-arrow2.png" alt="dotted-arrow2" class="dotted-line2">
            </div>
          </div>
          <div class="col"></div>
          <div class="col-sm-12 col-md-3">
            <div class="share-boxes">
              <img src="https://i.ibb.co/StC3RWk/img3.png" alt="img3" border="0">
              <p>Get ₹ {{App\Models\ReferPrice::first()->share_price}} for every share</p>
            </div>
          </div>
        </div>
        <div class="row refer-form-sec">
          <div class="col">
            <div class="refer-image">
              <img src="https://i.ibb.co/72ngXX8/big-image.jpg" alt="big-image" border="0" />
            </div>
          </div>
          <div class="col">
            <div class="refer-form">
              <ul>
                <!--<li class="facebook-color"><a href="#">Facebook</a></li>-->
                <!--<li class="youtube-color"><a href="#">you tube</a></li>-->
                <!--<li class="twitter-color"><a href="#">twitter</a></li>-->
              </ul>
            </div>
            <div class="refer-form-content">
              <h2 class="text-purple">Friends To Friends</h2>
              <p>Talking about friends  and suggest best stay option. You can start <a href="#" class="text-purple">NOW!</a></p>
             <form action="#" method="post" class="mt-2">
               <input type="text" name="Your Name" placeholder="Your Friend Name">
               <input type="email" name="Your Email" placeholder="Your Friend Email">
               <p>
                 <label class="container-checkbox">i have read and accept the T & C and privacy policy
                   <input type="checkbox">
                   <span class="checkmark"></span>
                 </label></p>
               <button class="bg-purple">REFER & EARN</button>
             </form>
              	<div class="row mx-1">


			@if(Auth::id())
            @php
                $join_price=App\Models\ReferPrice::first()->join_price;
            @endphp
		<a style = "color:white; border:1px green groove; background-color:#49adb3" href="whatsapp://send?text= Hi This is Referel Code {{'NSN'.Auth::id()}} Join Through This Refer Code You Will Get Rs {{$join_price}} !    https://www.nsnhotels.com " data-action="share/whatsapp/share" class = "buttonarea text-center btn commonbtn">Share via Whatsapp <img src = "https://cliply.co/wp-content/uploads/2021/08/372108180_WHATSAPP_ICON_400.gif" width = "10%"></a>
	@else
		<a style = "color:white; border:1px green groove; background-color:#49adb3" href="#" data-action="share/whatsapp/share" class = "buttonarea text-center btn commonbtn">Login for share your refer link through whatsapp <img src = "https://cliply.co/wp-content/uploads/2021/08/372108180_WHATSAPP_ICON_400.gif" width = "10%"></a>
		@endif

        @if(Auth::id())
		 <div class="d-flex align-items-center mt-3">
                <input type="text" id="Refer" class="form-control copyinput" value="{{'NSN'.Auth::id()}}">
                <input type="button" class="btn form-control copybtn bg-purple text-white border-0 rounded-0 copy-refer" value="Copy Code">
                @else
                    <a  href="/login" class="btn bg-purple mt-2 form-control text-white border-0 rounded-0 ">Please Login for share you code</a>
                @endif
         </div>

	</div>
            </div>
          </div>
        </div>

    </div>
    <br>
    <br>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  </body>
  <script>
       @if(Auth::check())
  var copyButton = document.querySelector('.copybtn');
  var copyInput = document.querySelector('.copyinput');

  copyButton.addEventListener('click', function(e) {
    e.preventDefault();
    var text = copyInput.select();
    document.execCommand('copy');
  });

  copyInput.addEventListener('click', function() {
    this.select();
  });
@endif


  </script>
</html>

@stop
