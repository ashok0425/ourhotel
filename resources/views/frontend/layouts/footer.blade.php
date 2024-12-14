<footer>
    <div class="footerarea custom-bg-primary">
        <!--List of loction start-->

        <!--List of location end-->
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-3 col-md-3">
                    <div class="mb-2 custom-text-white custom-fw-800 custom-fs-18 mb-3">About NSN Hotels</div>
                    <p class="custom-text-white line-height-2 custom-fs-12">Nsnhotels provides online Hotel Bookings of
                        hotels and resorts in India. Book budget, cheap and luxury hotels or resorts at cost effective
                        prices.</p>
                    <ul class=" d-flex custom-text-white custom-fw-700 custom-fs-18">
                        <li>Follow us :</li>
                        <li><a class="custom-text-white  mx-1" href="https://www.facebook.com/NSNHOTELBOOKING/"
                                target="_blank"><i class="fab fa-facebook"></i></a></li>
                        <li><a class="custom-text-white  mx-1"href="https://twitter.com/HotelsNsn?t=_Fi2KuR6_6-MZO-ipDqYCQ&s=09"
                                target="_blank"><span class="fab fa-twitter"></span></a></li>
                        <li><a class="custom-text-white  mx-1" href="https://instagram.com/nsn_hotels?utm_medium=copy_link"
                                target="_blank"><span class="fab fa-instagram"></span></a></li>
                        <li><a class="custom-text-white  mx-1" href="https://www.linkedin.com/company/nsn-hotels/"
                                target="_blank"><span class="fab fa-linkedin"></span></a></li>
                        <li><a class="custom-text-white  mx-1" href="https://youtube.com/channel/UC9k_pfRBtPlD4GtpzgYrDTg"
                                target="_blank"><span class="fab fa-youtube"></span></a></li>
                        <li><a class="custom-text-white  mx-1" href="https://pin.it/76hl1As" target="_blank"><span
                                    class="fas fa-pinterest"></span></a></li>
                    </ul>
                    <p class="custom-fs-16 custom-text-white">Let me recommend you this application</p>
                    <div class="row">
                        <div class="col-md-6 col-6">
                            <a href="https://play.google.com/store/apps/details?id=com.hotel.nsn">
                                <img src="{{ getImageurl('playstore.svg', true) }}" alt="NSN HOTELS Play Store"
                                    class="img-fluid">
                            </a>
                        </div>
                        <div class="col-md-6 col-6">
                            <a href="https://apple.co/3m8XXgO" class="py-5">
                                <img src="{{ getImageurl('appstore.svg', true) }}" alt="NSN HOTELS APP Store"
                                    class="img-fluid ">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3 col-md-3">
                    <div class="mb-2 custom-text-white custom-fw-800 custom-fs-18 mb-3">Contact us</div>
                    <ul class="">
                        <li class="my-2"><i class="fas fa-envelope custom-text-white"></i> <a
                                href="mailto:admin@nsnhotels.com" class="custom-text-white">info@nsnhotels.com</a></li>
                        <li class="my-2"><i class="fas fa-envelope custom-text-white"></i> <a
                                href="mailto:sales@nsnhotels.com" class="custom-text-white">amit@nsnhotels.com</a></li>
                        <li class="my-2"><i class="fas fa-phone custom-text-white"></i> <a href="tel:(+91)9958277997"
                                class="custom-text-white">(+91) 99582 77997</a></li>
                        <li class="my-2"><i class="fas fa-phone custom-text-white"></i> <a href="tel:(+91)7683003096"
                                class="custom-text-white">(+91) 7982523208</a></li>
                    </ul>
                </div>
                <div class="col-12 col-sm-3 col-md-3">
                    <div class="mb-2 custom-text-white custom-fw-800 custom-fs-18 mb-3">Payment Methods</div>
                    <ul class="d-flex  w-75">
                        <li class="bg-white mx-1 p-2 custom-border-radius-5"><img
                                src="{{ asset('frontend/images/american.png') }}" alt="Payment Methods" /></li>
                        <li class="bg-white mx-1 p-2 custom-border-radius-5"><img
                                src="{{ asset('frontend/images/discover.png') }}" alt="Payment Methods" /></li>
                        <li class="bg-white mx-1 p-2 custom-border-radius-5"><img
                                src="{{ asset('frontend/images/master.png') }}" alt="Payment Methods" /></li>
                        <li class="bg-white mx-1 p-2 custom-border-radius-5"><img
                                src="{{ asset('frontend/images/paypal.png') }}" alt="Payment Methods" /></li>
                        <li class="bg-white mx-1 p-2 custom-border-radius-5"><img
                                src="{{ asset('frontend/images/visa.png') }}" alt="Payment Methods" /></li>
                    </ul>
                    <p class="line-height-2 custom-fs-12 custom-text-white mt-1">You can pay the charges of booking
                        amount directly online or through the scan code .
                        You can ask our team for the payment link also. </p>
                </div>

                <div class="col-12 col-sm-3 col-md-3">
                    <div class="mb-2 custom-text-white custom-fw-800 custom-fs-18 mb-3">Stay in touch</div>
                    <form class="nsnhotelssubscribe" action="{{ route('subscribe') }}" method="post">
                        @method('post')
                        @csrf
                        <input type="email" placeholder="Your email" name="email" class="form-control" required />
                        <button class="nsnhotelssubcribebt">Subscribe</button>


                    </form>
                    <div class="center mt-2">
                        {{-- <img src="{{getImageUrl('payment-qr.jpeg',true)}}" class="img-fluid w-50" alt="Payment QR" /> --}}
                    </div>
                </div>
            </div>
            <div class="nsnhotelsfooterbottom mt-2">
                <div class="row">
                    <div class="col-12 col-sm-3 col-md-3 custom-text-white">
                        <p>© {{ now()->year }}, All rights reserved.</p>
                    </div>
                    <div class="col-12 col-sm-4 col-md-4 text-center custom-text-white">
                        <p>NSN Hotels Made with <span class="fas fa-heart text-danger"></span> by <a
                                href="https://nsnhotels.com" target="_blank"
                                class="custom-text-white custom-fw-800">Nsn.</a></p>
                    </div>
                    <div class="col-12 col-sm-5 col-md-5">
                        <ul class=" d-flex justify-content-between">
                            <li><a href="/about-us"
                                class="custom-text-white custom-fs-16">About us</a></li>
                            <li><a href="https://www.nsnhotels.com/Cancellation-and-Reservation.pdf"
                                    class="custom-text-white custom-fs-16">Cancellation Policy</a></li>
                            <li><a href="{{ url('/privacy') }}"
                                    class="custom-text-white custom-fs-16">Privacy Policy</a></li>
                            <li><a href="{{ route('page_contact') }}" class="custom-text-white custom-fs-16">Contact
                                    us</a></li>
                            <li><a href="{{ route('post_list_all') }}"
                                    class="custom-text-white custom-fs-16">Blog</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
