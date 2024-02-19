<style>
@media screen and (max-width: 325px){
    .topemail span{
        font-size:12px !important;
    }
    .topnum span{
        font-size: 12px !important;
    }
}
 </style>
 <div class="top-header p-2">
     <div class="container-fluid d-flex">
         <div class="col-md-7 col-lg-6 contect-info">
             <div class="row">
                 <a href="mailto:@isset($web_settings['Maintopbaremail']) {{$web_settings['Maintopbaremail'] ?? '' }} @endisset" class="px-0 topemail col-auto col-md-6 col-lg-5 col-xl-4 d-flex align-items-center"><img
                         src="{{ asset('assets/images/email.svg') }}"
                         alt="Email Icon"><span>@isset($web_settings['Maintopbaremail']) {{$web_settings['Maintopbaremail'] ?? '' }} @endisset</span></a>
                 <a href="tel:@isset($web_settings['Ph_num']) {{$web_settings['Ph_num'] ?? '' }} @endisset" class="topnum col-auto col-md-5 col-lg-5 col-xl-4 px-0"><img src="{{ asset('assets/images/phone.svg') }}"
                         alt="Phone Icon"> <span>@isset($web_settings['Ph_num']) {{$web_settings['Ph_num'] ?? '' }} @endisset</span></a>
             </div>
         </div>
         <div class="col-md-5 col-lg-6 d-md-flex justify-content-end align-items-center social-icon d-none">

             <a href="@isset($web_settings['fblink']) {{$web_settings['fblink'] ?? '' }} @endisset" target="_blank"><img src="{{ asset('assets/images/facebook.svg') }}"
                     alt="Facebook icon" width="25" height="auto"> </a>
             <a href="@isset($web_settings['inlink']) {{$web_settings['inlink'] ?? '' }} @endisset" target="_blank" style="margin: 0px 8px;"><img src="{{ asset('assets/images/linkedin.svg') }}" alt="Linedin icon"
                     width="25" height="auto"> </a>
             <a href="@isset($web_settings['instlink']) {{$web_settings['instlink'] ?? '' }} @endisset" target="_blank"><img src="{{ asset('assets/images/instagram.svg') }}"
                     alt="Instagram icon" width="25" height="auto"> </a>
             <a href="@isset($web_settings['xlink']) {{$web_settings['xlink'] ?? '' }} @endisset" target="_blank"><img src="{{ asset('assets/images/Twitter-Logо.png') }}"
                     alt="Twitter icon" width="40" height="auto"> </a>
         </div>
     </div>
 </div>
