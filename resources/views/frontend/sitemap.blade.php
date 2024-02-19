@extends('layouts.app')
@section('content')
@include('layouts.navbar')
<style>
    .sitemap-heading{
        font-size: 3.4rem;
    }
    .sitelinks li{
        margin: 10px 0px;
    }
</style>
<div class="container-fluid my-5">
    <div class="row py-5 mx-4 mx-lg-5 ">
        <div class="col-12 mb-2">
            <h2 class="fw-bolder sitemap-heading" id="text-color">Sitemap</h2>
        </div>
        <div class="col-12">
            <h4 class="fw-bold">
                Can't find what you're looking for? Here's a guide to our website.
            </h4>
        </div>
    </div>
    <div class="row mx-5 mb-5 pb-5">
        <div class="col-lg-3 d-none d-lg-inline-block">
            <div class="card align-items-center text-center py-4 gap-2">
                <img src="{{url('assets/images/profile.png')}}" class="w-25 rounded-circle" alt="...">
                <div class="card-body text-center">
                  <h5 class="card-title">Need help? We’re here</h5>
                  <p class="card-text">Speak to the London-based team. Our office is open 8am to 7pm Mon-Thurs, 8am to 5:30pm Fri.</p>
                  <a href="mailto:hello@247tutors.co.uk" class="text-decoration-none mt-1">Contact us</a>
                </div>
              </div>
        </div>
        <div class="col-lg-9 col-12">
            <div class="row px-lg-5">
                <div class="col-md-3 col-12">
                    <h4 class="pb-2 fw-bold">Main Link's</h4>
                    <ul class="sitelinks">
                        <li><a href="{{url('/')}}" class="text-decoration-none">Home page</a></li>
                        <li><a href="{{url('/student-apply-steps')}}" class="text-decoration-none">How it works</a></li>
                        <li><a href="{{url('/prices')}}" class="text-decoration-none">Pricing</a></li>
                        <li><a href="{{url('/faq')}}" class="text-decoration-none">About</a></li>
                        <!--<li><a href="{{url('/')}}" class="text-decoration-none">Contact</a></li>-->
                        <li><a href="{{url('/tutor-apply-steps')}}" class="text-decoration-none">Becoming a tutor</a></li>
                        <!--<li><a href="{{url('/')}}" class="text-decoration-none">Schools</a></li>-->
                        <li><a href="{{url('/blogs')}}" class="text-decoration-none">Blog</a></li>
                        <li><a href="{{url('/blogs')}}" class="text-decoration-none">Subject answers</a></li>
                        <!--<li><a href="{{url('/')}}" class="text-decoration-none">Reviews of tutors</a></li>-->
                    </ul>
                </div>
                <div class="col-md-3 col-12">
                    <h4 class="pb-2 fw-bold">Your Account</h4>
                    <ul class="sitelinks">
                        <li>Login
                            <ul>
                                <li><a href="{{url('/login-roles')}}" class="text-decoration-none">Parents</a></li>
                                <li><a href="{{url('/login-roles')}}" class="text-decoration-none">Students</a></li>
                                <li><a href="{{url('/login-roles')}}" class="text-decoration-none">Tutors</a></li>
                            </ul>
                        </li>
                        <li>Signup
                            <ul>
                                <li><a href="{{url('/select-user-type')}}" class="text-decoration-none">Parents</a></li>
                                <li><a href="{{url('/select-user-type')}}" class="text-decoration-none">Students</a></li>
                                <li><a href="{{url('/select-user-type')}}" class="text-decoration-none">Tutors</a></li>
                            </ul>
                        </li>
                        <li>Forgotton password
                            <ul>
                                <li><a href="{{url('/password/forget')}}" class="text-decoration-none">Parents</a></li>
                                <li><a href="{{url('/password/forget')}}" class="text-decoration-none">Students</a></li>
                                <li><a href="{{url('/password/forget')}}" class="text-decoration-none">Tutors</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-12">
                    <h4 class="pb-2 fw-bold">Find a tutor</h4>
                    <ul class="sitelinks">
                        <li><a href="#!" class="text-decoration-none">View tutors</a></li>
                        <li><a href="#!" class="text-decoration-none">Send a tutor request</a></li>
                        <li><a href="#!" class="text-decoration-none">Tutoring around the UK</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-12">
                    <h4 class="pb-2 fw-bold">Info</h4>
                    <ul class="sitelinks">
                        <li><a href="{{url('/faq')}}" class="text-decoration-none">FAQ's</a></li>
                        <li><a href="{{url('/privacypolicy')}}" class="text-decoration-none">Private Policy</a></li>
                        <li><a href="{{url('/testimonials')}}" class="text-decoration-none">Terms and Conditions</a></li>
                        <li><a href="#!" class="text-decoration-none">Press</a></li>
                        <li><a href="#!" class="text-decoration-none">Online Safety</a></li>
                        <li><a href="{{url('/privacypolicy')}}" class="text-decoration-none">Safeguarding Policy</a></li>
                        <li><a href="#!" class="text-decoration-none">Safeguarding Procedures</a></li>
                        <li><a href="{{url('/videos-guides')}}" class="text-decoration-none">Lesson space Demo</a></li>
                        <li><a href="#!" class="text-decoration-none">Using a Tablet</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
