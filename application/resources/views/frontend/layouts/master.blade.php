<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
    <meta name="robots" content="index, no-follow" />
    <link rel="icon" sizes="16x16" href="{{ getImageUrl(setting('logo')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @if (url()->current() == '/')
        <title>Home - NSN Hotels</title>
        <meta name="title" content="The Best Top 10 Online Hotel Booking Websites" />
        <meta name="keyword"
            content="Best online hotel booking site, online hotel booking sites, online hotel booking websites, websites to book hotels" />
        <meta name="description"
            content="NSN Hotels provides the best online hotel booking site in India. Get the best hotel prices and huge discounts on your online hotel bookings. It is also very easy to use.
            both done" />
    @endif

    <link rel="preload stylesheet" href="{{ filepath('frontend/css/bootstrap.css') }}" as="style" type="text/css"
        onload="this.rel='stylesheet'">
    @if (request()->path() != '/')
        <link rel="preload stylesheet" href="{{ filepath('frontend/build/css/intlTelInput.min.css') }}" as="style">
        <link rel="preload stylesheet" href="{{ asset('splide.css') }}" as="style">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <link rel="preload stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css"
        as="style">
    <link href="{{ filepath('frontend/css/daterangepicker.css') }}" rel="preload stylesheet" as="style" />
    <link rel="preload stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css"
        as="font" crossorigin>
    <link href="{{ filepath('frontend/css/index/style.css') }}" rel="preload stylesheet" as="style"
        type="text/css" />
    <link href="{{ filepath('frontend/css/index/nsnhotels.css') }}" rel="preload stylesheet" as="style"
        type="text/css" />

    <style>
        .bg_animities {
            background: rgb(158, 156, 156);
        }

        .faq h2 {
            font-weight: 700 !important;
            font-size: 26px !important;
            color: #000 !important;
        }

        .accordion-title a {
            font-weight: 700;
            font-size: 19px;
            color: var(--color-primary)
        }

        .footerarea p {
            color: #fff !important;
        }

        #bannerslider {
            position: relative;
        }

        #bannerslider .owl-nav {
            position: absolute;
            top: 60% !important;
        }

        .nsnbannerbackground-2 {
            max-height: 500px !important;
        }



        .custom-bg-gradient {
            background: rgb(255, 255, 255);
            background: linear-gradient(0deg, var(--color-gray) 50%, var(--color-primary) 50%);
        }

        .text-capitilize {
            text-transform: capitalize;
        }

        del {
            text-decoration: line-through !important;
        }

        @media (max-width:560px) {
            .nsnbannerbackground-2 {
                max-height: 750px !important;
            }

            .nsnhttext {
                margin-top: 5rem;
            }
        }

        .modal-backdrop {
            background: rgba(0, 0, 0, .4) !important;
            z-index: -1;
        }
        .text-purple{
            color: #5f319c!important;
        }
        .bg-purple{
            background-color: #5f319c!important;
        }
    </style>
    @stack('style')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-261685512-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-261685512-1');
    </script>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PCPKR6W');
    </script>
    <!-- End Google Tag Manager -->
    <style>
        .breadcrumarea:before {
            background: #5f319c !important;
        }
    </style>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PCPKR6W" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>

        <!-- Facebook Pixel Code -->
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '1192013951663343');
            fbq('track', 'PageView');
        </script>
        <noscript>
            <img height="1" width="1"
                src="https://www.facebook.com/tr?id=1192013951663343&ev=PageView
    &noscript=1" />
        </noscript>
        <!-- End Facebook Pixel Code -->
    </header>
    @include('frontend.layouts.topheader')

    @if (Request::segment(1) == null)
        @include('frontend.layouts.citylist')
    @endif


    @yield('main')

    @include('frontend.home.partials.faq')

    @include('frontend.layouts.mobile_menu')
    @include('frontend.layouts.footer')
    @include('frontend.layouts.script')
    @include('frontend.layouts.js')

    @stack('scripts')

    <script>
        $(document).ready(function() {
            @if (Session::has('messege')) //toatser
                var type = "{{ Session::get('alert-type', 'info') }}"
                switch (type) {
                    case 'info':
                        toastr.info("{{ Session::get('messege') }}");
                        break;
                    case 'success':
                        toastr.success("{{ Session::get('messege') }}");
                        break;
                    case 'warning':
                        toastr.warning("{{ Session::get('messege') }}");
                        break;
                    case 'error':
                        toastr.error("{{ Session::get('messege') }}");
                        break;
                }
            @endif

            $('.offer-wrapper a').click(function(e) {
                e.preventDefault()
                let url = $(this).attr('href');
                $.ajax({
                    url: '{{ url('apply-offer') }}',
                    data: {
                        url: url
                    },
                    success: function() {
                        toastr.success('Offer Applied.Now book any hotel to get offer.')
                        setTimeout(() => {
                            location.href = url

                        }, 2000);
                    }

                })
            })
        })
    </script>

    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script>

    <script>
        const firebaseConfig = {
            apiKey: "AIzaSyA57QHsvQcx1OCPIyA92Vs78xiQ9t-hnTA",
            authDomain: "nsn-hotels.firebaseapp.com",
            projectId: "nsn-hotels",
            storageBucket: "nsn-hotels.appspot.com",
            messagingSenderId: "1098625418948",
            appId: "1:1098625418948:web:07cffeebca114606ca6b91",
            measurementId: "G-4NBSM463QS"
        };

        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        function initNotification() {
            console.log('Device  saved.');
            messaging
                .requestPermission().then(function() {
                    return messaging.getToken()
                }).then(function(response) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '{{ route('fcmToken') }}',
                        type: 'POST',
                        data: {
                            token: response
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log('Device token saved.');
                            localStorage.setItem('fcm_token', response.token)

                        },
                        error: function(error) {
                            console.log(error);
                        },
                    });
                }).catch(function(error) {
                    console.log(error);
                });
        }

        messaging.onMessage(function(payload) {
            const title = payload.notification.title;
            const options = {
                body: payload.notification.body,
                icon: payload.notification.icon,
            };
            new Notification(title, options);
        });
    </script>


    {{-- ask for permission after login  --}}
    @auth
        <script>
            if (!localStorage.getItem('fcm_token') && localStorage.getItem('fcm_token') == null) {
                addEventListener('load', initNotification())
            }
        </script>
        @endif


    </body>

    </html>
