<style>
     input:checked span{
        background: #000!important;
    }
    .searchform{
        margin-top: 0!important;
    }
    #serach_form_btn{
border-radius: 60px 10px 10px 60px;
border: 10px solid #ef6614;
background: #ef6614!important;
width:100%;
text-align: center;
    }
    .nsn-search .card{
        border-radius: 10px!important;
    }
    .whereicon.searchinput{
        border: 0px!important;
    }
    .searchinput{
        border-right: 0!important;
    }
    input:focus{
        outline: none!important;
        box-shadow: none!important;
    }
    .nsn-search .searchform .form-control{
        padding-top: 1.5rem!important;
        padding-left:1rem;
    }
 .border_left_right{
    border-left: 1px solid rgb(185, 182, 182);
    border-right: 1px solid rgb(185, 182, 182);

 }
 @media  (max-width:760px){
    #serach_form_btn{
border-radius: 60px 60px 60px 60px;
border: 10px solid #ef6614;
background: #ef6614!important;
width: 90%;
margin: auto;
display: flex;
text-align: center;
justify-content: center;
    }

    .border_left_right{
    border-top: 1px solid rgb(185, 182, 182);
    border-bottom: 1px solid rgb(185, 182, 182);
    border-left: 0px solid rgb(185, 182, 182);
    border-right: 0px solid rgb(185, 182, 182);

 }
 .border_left_right .mx-3{
    margin-left: 0!important;
    margin-right: 0!important;

 }
 }
</style>
<div class="nsn-search">
                <div class="card border-0 p-0">
                    <div class="card-body p-0">
                <form class="searchform" action="{{route('page_search_listing')}}" method="get" id="search-hotel" class="p-0 m-0">
                    <div class="row m-0">
                        <div class="col-md-4 py-3 ps-3 pr-0">
                            <div class="form-group searchinput  mx-0">
                                <span class="labeltext"><i class="fas fa-hotel"></i> Where are you going?</span>
                                <input class="form-control open-suggestion" id="location_search" required name="location_search" type="text" placeholder="City, Street or Property Name" autocomplete="off">
                                <input type="hidden" id="search_type" name = "type">
                                <input type="hidden" id="search_id" name="id" required>
                                <input type="hidden" id="total_room" name="total_room" value="1">
                                <input type="hidden" id="total_guest" name="total_guest" value="1">
                                <input type="hidden" id="token" value="{{csrf_token()}}">
                                <input type="hidden" name="search" id="search">
                            </div>
                            <div class="search-result search-suggestions"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="border_left_right py-3">

                            <div class="form-group searchinput mx-3">
                                <span class="labeltext"><i class="fas fa-calendar"></i> Check in Check out</span>
                                <input type="text" class="form-control"  id="checkInOut" value="">
                                <input type="hidden" class="check-in-field" name="check_in_field" value="">
                                <input type="hidden" class="check-out-field" name="check_out_field"  value="">
                              </div>
                            </div>

                        </div>
                        <div class="col-md-3 py-3 ">
                            <div class="form-group searchinput">
                                <span class="labeltext"><i class="fas fa-users"></i> How many you are?</span>
                                <div class="panel-dropdown custom-bg-white">
                                    <div class="form-control guestspicker">
                                    <span id ="room">1</span> Room, <span class="gueststotal">1</span> Guest</div>
                                    <div class="panel-dropdown-content custom-bg-white">
                                        <div class="row d-none">
                                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                                <label class="custom-text-primary custom-fw-700 custom-fs-14">Room</label>
                                            </div>
                                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                                <label class="custom-text-primary custom-fw-700 custom-fs-14">Guest</label>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row" id="room1">
                                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                                <label>Room 1</label>
                                            </div>
                                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                                <div class="guests-button">
                                                    <div class="minus" onclick="guest_room()"></div>
                                                    <input type="text" name="booking-Room" id="guest"class="booking-guests" value="1" onkeyup ="" max="3" min="0"
                                                     onKeyUp="if(this.value>3){this.value='3';}else if(this.value<1){this.value='1';}"/>
                                                    <div class="plus" onclick="guest_room()"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="room2" >
                                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                                <label>Room 2</label>
                                            </div>
                                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                                <div class="guests-button" >
                                                    <div class="minus" onclick="guest_room()"></div>
                                                    <input type="text" name="booking-Room" id="guest1"onfocusout="if(this.value.length==2) return false;"class="booking-guests" value="0" onkeyup ="" max="3" min="0"/>
                                                    <div class="plus" onclick="guest_room()"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="room3" >
                                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                                <label>Room 3</label>
                                            </div>
                                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                                <div class="guests-button">
                                                    <div class="minus" onclick="guest_room()"></div>
                                                    <input type="text" name="booking-Room" id="guest2"class="booking-guests" value="0" onkeyup ="" max="3" min="0"/>
                                                    <div class="plus" onclick="guest_room()"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="room4" >
                                            <div class="col-6 col-sm-6 col-sm-6 text-left" >
                                                <label>Room 4</label>
                                            </div>
                                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                                <div class="guests-button">
                                                    <div class="minus" onclick="guest_room()"></div>
                                                    <input type="text" name="booking-Room" id="guest3"class="booking-guests" value="0" onkeyup ="" max="3" min="0"/>
                                                    <div class="plus" onclick="guest_room()"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="room5" >
                                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                                <label>Room 5</label>
                                            </div>
                                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                                <div class="guests-button">
                                                    <div class="minus" onclick="guest_room()"></div>
                                                    <input type="text" name="booking-Room" id="guest4"class="booking-guests" value="0" onkeyup ="" max="3" min="0"/>
                                                    <div class="plus" onclick="guest_room()"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                                <label><span id="delete" onclick = "del_room()">Delete Room</span></label>
                                            </div>
                                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                                <label><span id="addroom" onclick = "add()">Add Room</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2  p-0 d-md-flex justify-content-end">
                            <button type="button" id="serach_form_btn"  value="Search" class="btn btn-primary custom-fw-700 text-uppercase" disabled>Search</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

