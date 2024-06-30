<style>
    .index-999{
        z-index: 9999999999;
    }
</style>
<form action="{{route('page_search_listing')}}" id="search-hotel" class="mt-3 mt-md-0">
    <div class="row">
        <div class="col-md-3">
            <label class="custom-text-white custom-fs-12 mb-1 text-uppercase custom-fw-600">City , Area or property name</label>
            <input type="search" class="border-0 form-control outline-none border-none open-suggestion " placeholder="{{$cityname}}" id="location_search" name="location_search" value="{{isset($_GET['search'])?$_GET['search']:''}}">
            <input type="hidden" id="search_type" name = "type" value="{{$type}}">
            <input type="hidden" id="search_id" name="id" value="{{$id}}">
            <input type="hidden" id="total_room" name="total_room" value="1">
            <input type="hidden" id="total_guest" name="total_guest" value="1">
            <input type="hidden" id="token" value="{{csrf_token()}}">
            <input type="hidden" name="search" id="search">
            <div class="search-result index-999 search-suggestions"></div>
        </div>

        <div class="col-md-3 ">
            <label class="custom-text-white custom-fs-12 mb-1 text-uppercase custom-fw-600">Check in -Check out</label>
            <input type="search" class="border-0 form-control outline-none border-none "  id="checkInOut">
            <input type="hidden" class="check-in-field" name="check_in_field" value="">
            <input type="hidden" class="check-out-field" name="check_out_field"  value="">
        </div>
        <div class="col-md-2">
            <label class="custom-text-white custom-fs-12 mb-1 text-uppercase custom-fw-600">Price Range</label>
        <select name="budget" id="budget"class="form-control">
            <option value="">--select range--</option>
            <option value="0,1000">upto 1000</option>
            <option value="1001,5000">1001 - 5000</option>
            <option value="5001,12000">5001 - 12000</option>
            <option value="12000,50000">12000+</option>

        </select>
        </div>

        <div class="col-md-2">
            <label class="custom-text-white custom-fs-12 mb-1 text-uppercase custom-fw-600">Guest & Rooms</label>
            <div class="panel-dropdown">
                <div class="form-control guestspicker ">
                    <span id ="room">1</span> Room, <span class="gueststotal">1</span> Guest</div>
                    <div class="panel-dropdown-content custom-bg-white">
                        <div class="row">
                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                <label>Room</label>
                            </div>
                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                <label>Guest</label>
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
                                    <input type="text"  id="guest"class="booking-guests" value="1" onkeyup ="guest_room()" max="3" min="0"
                                     onKeyUp="if(this.value>3){this.value='3';}else if(this.value<1){this.value='1';}"/>
                                    <div class="plus" onclick ="guest_room()"></div>
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
                                    <input type="text" name="" id="guest1"onfocusout="if(this.value.length==2) return false;"class="booking-guests" value="0" onkeyup ="guest_room()" max="3" min="0"/>
                                    <div class="plus" onclick ="guest_room()"></div>
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
                                    <input type="text" name="" id="guest2"class="booking-guests" value="0" onkeyup ="guest_room()" max="3" min="0"/>
                                    <div class="plus" onclick ="guest_room()"></div>
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
                                    <input type="text" name="" id="guest3"class="booking-guests" value="0" onkeyup ="guest_room()" max="3" min="0"/>
                                    <div class="plus" onclick ="guest_room()"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row d-none" id="room5">
                            <div class="col-6 col-sm-6 col-sm-6 text-left">
                                <label>Room 5</label>
                            </div>
                            <div class="col-6 col-sm-6 col-sm-6 text-center">
                                <div class="guests-button">
                                    <div class="minus" onclick="guest_room()"></div>
                                    <input type="text" name="" id="guest4"class="booking-guests" value="1" onkeyup ="guest_room()" max="3" min="0"/>
                                    <div class="plus" onclick ="guest_room()"></div>
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


        <div class="col-md-2">
            <label class="custom-text-white custom-fs-12 mb-1 text-uppercase custom-fw-600"></label>
            <button type="submit" class="border-0 btn custom-fw-600 custom-text-white custom-bg-secondary form-control outline-none border-none " id="serach_form_btn">UPDATE SEARCH</button>
        </div>

    </div>
</form>
