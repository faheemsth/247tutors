@extends('layouts.app')
@section('content')
@include('layouts.navbar')

<style>
    .lessonheading{
        font-size: 3rem;
        font-weight: 600;
        margin-bottom: 10px;
    }
    @media screen and (max-width: 430px){
        .lessonheading{
            font-size:2rem;
        }
    }
</style>

    <div class="container-fluid my-5 py-5">
        <div class="row my-5 mx-md-5">
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10 col-12  text-center">
                        <h1 class="lessonheading" id="text-color">Lesson space video demo</h1>
                        <h6 style="line-height: 1.9rem;letter-spacing: 0.02rem;">
                            Find out what it feels like to learn in the lesson space. This video introduces you to all the features at your fingertips: video, voice chat, a shared whiteboard, and the ability to upload documents.
                        </h6>
                    </div>
                </div>
                <div class="row justify-content-center my-4">
                    <div class="col-lg-4 col-md-6 col-10">
                        <video controls muted autoplay width="100%">
                            <source src="example.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <h5>Want to give it a go? Sign up to try out the lesson space.</h5>
                        <a href="" class="btn px-5 fw-bold py-3 mt-4 fs-5  text-primary" style="background-color: #ABFF00;">Try out the lesson space</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
