{{-- @dd(session()->has('key')) --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ asset('assets/favicon/favicon.ico.png')}}" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '247tutors') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Bootstrap Css file -->
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">

  <!-- font awesome icons -->
  <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">

  <!-- Styles -->

   <!-- Styles -->
   <link rel="stylesheet" href="{{ asset('assets/css/Login.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/card2.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/findatutor.css') }}">
   <link rel="stylesheet" href="{{ asset('assets/css/find-tutor.css') }}">


    <!-- Slick slider CSS  -->
  <link rel="stylesheet" href="{{ asset('vendor/slick/slick-style.css') }}">

  <!-- range slider -->
  <link rel="stylesheet" href="{{ asset('assets/css/rSlider.min.css') }}">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/intlInputPhone.min.css')}}"> --}}
    <style>
        #overlaytens {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
      }
      #popuptens {
       display: none;
       position: fixed;
       top: 50%;
       z-index: 98765;
       left: 50%;
       transform: translate(-50%, -50%);
       padding: 20px;
       background: #fff;
       border: 1px solid #ccc;
       border-radius: 5px;
       box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
     }

     #closetens {
       position: absolute;
       top: -3px;
       right: 4px;
       font-size: 23px;
       cursor: pointer;
     }
.desktop-closed-message-avatar {
    animation: skew-y-shake 1.3s infinite;
}
.desktop-closed-message-avatar{
    top: 18px !important;
}
/*<span id="cookieBanner">*/
/*@if(request()->segment(1) == '' || request()->segment(1) == 'faq' || request()->segment(1) == 'find-tutor' || request()->segment(1) == 'blogs' || request()->segment(1) == 'prices'|| request()->segment(1) == 'student-apply-steps'|| request()->segment(1) == 'tutor-apply-steps' || request()->segment(1) == 'organization-apply-steps' || request()->segment(1) == 'login-roles' || request()->segment(1) == 'login' || request()->segment(1) == 'sitemap' || request()->segment(1) == 'privacypolicy' )*/
/*.footer-wrapper{*/
/*    padding-bottom:70px !important;*/
/*}*/
/*@endif*/
/*</span>*/

@keyframes skew-y-shake {
    0% { transform: skewY(-15deg); }
    5% { transform: skewY(15deg); }
    10% { transform: skewY(-15deg); }
    15% { transform: skewY(15deg); }
    20% { transform: skewY(0deg); }
    100% { transform: skewY(0deg); }
}
/*#botmanWidgetRoot div{*/
/*    max-width:250px !important;*/
/*}*/
.poptext{
    font-size: 15px ;
}
.cookiessection{
    width:25%;
    position:fixed;
    bottom: 8px;
    left:32px;
    z-index: 100040;
}
@media screen and (max-width: 780px){
    .poptext{
    width: 100%;
}
.cookiessection{
    width:35%;
    bottom: 8px;left:22px; 
}
}
@media screen and (max-width: 430px){
    #popuptens{
        width: 70%;
    }
    .cookiessection{
        width:75%;
    bottom: 2px;
    left:0px;
}
}
@media screen and (max-width: 325px){
    .poptext{
   font-size: 10px;
}
 .cookiessection{
        width:85%;
    
 }
}


.mobile-closed-message-avatar svg{
    padding-top: 0px !important;
    position: absolute !important;
    top: 50% !important;
    left: 50% !important;
    Transform: translate(-50%, -50%) !important;
}
#botmanWidgetRoot>div{
    min-width:150px !important;
}
 /* Initial style, set display to none */
 #cookiBanner {
      display: none;
      /* Add other styles as needed */
    }
.cookie-alert {
  position: fixed;
  bottom: 15px;
  left: 15px;
  width: 320px;
  margin: 0 !important;
  z-index: 9998989999;
  opacity: 0;
  transform: translateY(100%);
  transition: all 500ms ease-out;
}

.cookie-alert.show {
  opacity: 1;
  transform: translateY(0%);
  transition-delay: 1000ms;
}

/*google translate */
   .goog-te-gadget img{
    display:none !important;
    }
    body > .skiptranslate {
        display: none;
    }
    body {
        top: 0px !important;
    }
#google_translate_element{width:300px;float:right;text-align:right;display:block}
.goog-te-banner-frame.skiptranslate { display: none !important;}
body { top: 0px !important; }
#goog-gt-tt{display: none !important; top: 0px !important; }
.goog-tooltip skiptranslate{display: none !important; top: 0px !important; }
.activity-root { display: hide !important;}
.status-message { display: hide !important;}
.started-activity-container { display: hide !important;}


.VIpgJd-ZVi9od-ORHb{
    background-image: none !important;
    background-color: transparent;
    opacity: 0 !important;
}
.VIpgJd-ZVi9od-l4eHX-hSRGPd{
            display: none !important;
        }
        .goog-te-gadget{
            display: flex;
            font-size: 1px !important;
    color: #6660 !important;
        }
        .goog-te-combo {
            padding: 8px;
    border: 1px solid #8c8c8c;
    border-radius: 3px;
    background-color: #F8F9FA;
        }



    </style>
</head>
<body>
    <div id="app">
        @include('layouts/buttons')
        @include('layouts/topbar')
        {{-- @include('layouts/navbar') --}}

        <main>
            @yield('content')
        </main>
        <div id="popuptens">
            <div id="closetens"> <i class="fa-solid fa-xmark"></i></div>

            <img src="{{ asset('assets/images/shutterstock_1676998309 1.png') }}" width="100%" alt="">
            <div class="mt-3 row gap-2 justify-content-center">
                <a type="button" href='{{ route('studentApplySteps') }}' class="poptext col-auto btn px-5 py-2 mb-2"
                                style="background:linear-gradient(93.86deg, #063B00 9.41%, #000000 98.3%);
                                ;
                                color: white; border: none;">Become
                                a student <i class="fa-solid fa-chevron-right"></i></a>
                                <a type="button" href='{{ route('tutorApplySteps') }}' class="poptext col-auto btn px-5 py-2 mb-2"
                                style="background:linear-gradient(93.86deg, #063B00 9.41%, #000000 98.3%);
                                ;
                                color: white; border: none;">Become
                                a Tutor
                                {{-- <span style="color:rgba(29, 161, 242, 1);">It’s Free <i class="fa-solid fa-exclamation"></i>
                                </span> --}}
                                <i class="fa-solid fa-chevron-right"></i>
                            </a><br>
            </div>
          </div>

        @include('layouts/footer')
        @if(request()->segment(1) == '' || request()->segment(1) == 'faq' || request()->segment(1) == 'find-tutor' || request()->segment(1) == 'blogs' || request()->segment(1) == 'prices'|| request()->segment(1) == 'student-apply-steps'|| request()->segment(1) == 'tutor-apply-steps' || request()->segment(1) == 'organization-apply-steps' || request()->segment(1) == 'login-roles' || request()->segment(1) == 'login' || request()->segment(1) == 'sitemap' || request()->segment(1) == 'privacypolicy' )
       <div class="container cookiessection " id="cookiBanner">
           @if(!Auth::check())
            <div class="d-none row py-3  justify-content-center align-items-baseline" id="cookieBanner">
                <div class="col-auto text-white">
                    <h6 style="letter-spacing: 0.1rem">We use cookies to personalise your experience on the site. Let us know if you’re ok with this.</h6>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary" onclick="cookieUpdate()">YES, THAT'S OK</button>
                </div>
            </div>
            <div id="cookieNotification" class="card" style="display: none;">
                <div class="card-body">
                    <h5 class="card-title">&#x1F36A; Do you like cookies?</h5>
                    <p class="card-text">We use cookies to ensure you get the best experience on our website.</p>
                    <div class="btn-toolbar justify-content-end">
                        <button class="btn btn-primary" onclick="cookieUpdate('accept')">Accept</button>
                        <button class="ms-2 btn btn-danger" onclick="cookieUpdate('reject')">Reject</button>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
        </div>
    </div>

    <!-- jquery file -->
<script src="{{ asset('vendor/jquery/jquery3.7.0.js') }}"></script>
<!-- Slick slider jquery  -->
<script src="{{ asset('vendor/slick/slick-slide.js') }}"></script>
<!-- Bootstrap js file -->
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
<!-- main js file -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="{{ asset('assets/js/intlInputPhone.min.js') }}"></script>
<script src="{{ asset('assets/js/intlInputPhone.js') }}"></script>
<script src="http://translate.google.com/translate_a/element.js?cb=loadGoogleTranslate"></script>
    <script>
        function loadGoogleTranslate(){
            new google.translate.TranslateElement("google_element");
        }

    </script>
<script>
  function showCookieBanner() {
    var cookieBanner = document.getElementById("cookiBanner");
    if (cookieBanner) {
      cookieBanner.style.display = "block";
    }
  }
  setTimeout(showCookieBanner, 30000);
</script>
<script>
    $(document).ready(function () {
        // Check if the session cookie is set
        if (!sessionCookieExists()) {
            // If the session cookie is not set, show the cookie notification
            $('#cookieNotification').fadeIn();
        }
    });

    function sessionCookieExists() {
        // You need to replace 'your_session_cookie_name' with the actual name of your session cookie
        return document.cookie.indexOf('your_session_cookie_name=') !== -1;
    }

    function setSessionCookie() {
        // Set your session cookie with an expiration time (e.g., 1 day)
        var expirationDate = new Date();
        expirationDate.setDate(expirationDate.getDate() + 1); // 1 day from now
        document.cookie = 'your_session_cookie_name=true; expires=' + expirationDate.toUTCString() + '; path=/';
    }

    function cookieUpdate(action) {
        // Handle cookie acceptance or rejection
        if (action === 'accept') {
            // Perform actions when the user accepts cookies
            setSessionCookie();
        } else if (action === 'reject') {
            // Perform actions when the user rejects cookies
        }

        // Hide the cookie notification with a smooth fade-out animation
        $('#cookieNotification').fadeOut();
    }
</script>
            
        <script>
            $(document).ready(function() {
                var popupShown = localStorage.getItem('popupShown');

                // Check if the popup has been shown before
                if (!popupShown) {
                    setTimeout(function() {
                        $("#overlaytens").fadeIn(300);
                        $("#popuptens").fadeIn(300);
                    }, 100);
                }

                // Close Popup
                $("#closetens, #overlaytens").click(function() {
                    $("#overlaytens").fadeOut(300);
                    $("#popuptens").fadeOut(300);

                    // Set flag in localStorage indicating the popup has been shown
                    localStorage.setItem('popupShown', true);
                });
            });
        </script>


</body>
</html>

