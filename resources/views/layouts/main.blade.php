<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" >
<head>
    <link rel="icon" href="{{ asset('assets/favicon/favicon.ico.png')}}" type="image/x-icon">
	<title>@yield('title','') | 247tutors</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- initiate head with meta tags, css and script -->
	@include('include.head')
<style>
    table tr td{
        font-size: 14px !important;
    }
    table tr td button{
        font-size: 13px !important;
    }
    table tr td span {
        padding: 0.5rem 1rem !important;
    }
    table tr td a{
        font-size: 13px !important;
    padding: 0.2rem 0.5rem !important;
    }
</style>

</head>
<body id="app" >
    <div class="wrapper">
    	<!-- initiate header-->
    	@include('include.header')
    	<div class="page-wrap">
	    	<!-- initiate sidebar-->
	    	@include('include.sidebar')

	    	<div class="main-content">
	    		<!-- yeild contents here -->
	    		@yield('content')
	    	</div>
            <div id="overlaytens"></div>

	    	<!-- initiate chat section-->
	    	@include('include.chat')


	    	<!-- initiate footer section-->
	    	@include('include.footer')

    	</div>
    </div>

	<!-- initiate modal menu section-->



	<!-- initiate scripts-->
	@include('include.script')
	@yield('script')
</body>
</html>

