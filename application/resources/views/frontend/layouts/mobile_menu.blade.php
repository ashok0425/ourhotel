<style>
    .btn-icon-text{
    color: #fff!important;
  }
   .btn-icon-text i {
    height: 60px;
    line-height: 58px;
    width: 60px;
    display: inline-block;
    vertical-align: middle;
    font-size: 24px;
    border-radius: var(--fimobile-rounded);
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    margin-bottom: 5px;
   }
/* 15. footer */
.mobile_footers {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  z-index: 9;
  border-radius: 15px 15px 0 0;
  background-color: #fff;
  box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.07);
  -moz-box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.07);
  -webkt-box-shadow: 0px -5px 10px rgba(0, 0, 0, 0.07);
}

.mobile_footers .nav {
  align-items: center;
  max-width: 480px;
  margin: 0 auto;
  display: flex;
  justify-content: space-evenly;
}

.mobile_footers .nav .nav-item {
  height: 80px;
  flex-grow: 1;
}

.mobile_footers .nav .nav-item .nav-link {
  text-align: center;
  background: transparent;
  align-self: center;
  -webkit-align-self: center;
  -moz-align-self: center;
  height: 100%;
  color: #999999;
  padding: calc(10px - 5px) calc(10px - 10px);
}
.theme-radial-gradient {
  background: radial-gradient(ellipse at 30% 80%, var(--color-primary)  0%, var(--color-secondary)  50%, var(--color-primary) 100%);  
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
  border-radius: 50%;
    text-align: center;
    color: white;
    height: 40px;
    width: 40px;
}

.submenus i{
  line-height: 38px!important;
}


.mobile_footers .nav .nav-item .nav-link span {
  line-height: 20px;
  display: inline-block;
  vertical-align: middle;
}

.mobile_footers .nav .nav-item .nav-link span .nav-icon {
  font-size: 17px;
  height: 20px;
  line-height: 20px;
  width: 20px;
  display: inline-block;
  margin: 0 auto;
}

.mobile_footers .nav .nav-item .nav-link span .nav-text {
  font-size: 10px;
  line-height: 15px;
  display: block;
}

.mobile_footers .nav .nav-item .nav-link.active {
  color: var(--fimobile-footer-text-active);
}

.mobile_footers .nav .nav-item.centerbutton {
  padding: 10px;
  transition: none;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link {
  position: relative;
  padding: 8px;
  height: 76px;
  width: 76px;
  margin: 0 auto;
  border-radius: 0 0 40px 40px;
  margin-top: -30px;
  transition: none;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link > span {
  height: 60px;
  line-height: 60px;
  width: 60px;
  border-radius: 30px;
  margin: 0px auto 0 auto;
  color: #ffffff;
  box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
  -moz-box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
  -webkt-box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
}

.mobile_footers .nav .nav-item.centerbutton .nav-link > span img {
  opacity: 1;
  width: 16px;
  height: 25px;
  vertical-align: middle;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link > span i.close {
  opacity: 0;
  height: 24px;
  width: 24px;
  font-size: 0;
  line-height: 24px;
  display: inline-block;
  transform: rotate(-180deg);
  -webkit-transform: rotate(-180deg);
  -moz-transform: rotate(-180deg);
  position: absolute;
  left: 0;
  right: 0;
  top: 26px;
  margin: 0 auto;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link .nav-menu-popover {
  height: auto;
  padding:15px;
  border-radius: 12px;
  background-color: #001c77;
  color: #ffffff;
  position: absolute;
  bottom: 100%;
  width: 320px;
  left: -160px;
  margin-left: 38px;
  display: none;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link.active {
  background-color: #001c77;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link.active::after {
  content: "";
  position: absolute;
  right: 100%;
  top: 0;
  width: 20px;
  height: 20px;
  background-image: radial-gradient(ellipse at 0% 100%, transparent 0%, transparent 70%, #001c77 72%);
}

.mobile_footers .nav .nav-item.centerbutton .nav-link.active::before {
  content: "";
  position: absolute;
  left: 100%;
  top: 0;
  width: 20px;
  height: 20px;
  background-image: radial-gradient(ellipse at 100% 100%, transparent 0%, transparent 70%, #001c77 72%);
}

.mobile_footers .nav .nav-item.centerbutton .nav-link.active .nav-menu-popover {
  display: flex;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link.active > span img {
  opacity: 0;
}

.mobile_footers .nav .nav-item.centerbutton .nav-link.active > span i.close {
  opacity: 1;
  transform: rotate(0deg);
  -webkit-transform: rotate(0deg);
  -moz-transform: rotate(0deg);
  font-size: 22px;
}

.menu-open .mobile_footers {
  margin-bottom: -80px;
}

.footer-info {
  padding:15px 0px;
  line-height: 30px;
}
</style>
@if (Request()->segment(1)!='hotels')

<footer class=" mobile_footers d-block d-md-none">
    <div class="container">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item ">
                <a class="nav-link " href="{{route('user_my_place')}}">
                    <span class="theme-radial-gradient submenus">
                    <i class="fas fa-briefcase"></i>
                    </span>
                    <small class="nav-text text-dark">Booking</small>

                </a>
            </li>

        
            <li class="nav-item " >
                <a class="nav-link" href="{{route('page_search_listing')}}">
                    <span class="theme-radial-gradient submenus">
                        <i class="nav-icon fas fa-search"></i>
                    </span>
                    <small class="nav-text">Search</small>

                </a>
            </li>
          
            <li class="nav-item centerbutton">
                <a class="nav-link" href="{{route('home')}}">
                    <span class="theme-radial-gradient ">
                       

                        <i class="fas fa-home nav-icon"></i>

                    </span>
                   
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user_my_wallet')}}">
                    <span class="theme-radial-gradient submenus">
                        <i class="nav-icon fas fa-wallet"></i>
                    </span>
                    <small class="nav-text">Earning</small>

                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('user_profile')}}">
                    <span class="theme-radial-gradient submenus">
                        <i class="nav-icon fas fa-user"></i>
                    </span>
                    <small class="nav-text">Account</small>

                </a>
            </li>
        </ul>
    </div>
</footer>
@endif