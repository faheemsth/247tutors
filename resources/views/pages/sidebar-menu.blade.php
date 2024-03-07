@php
    $segment1 = request()->segment(1);
    $segment2 = request()->segment(2);
@endphp

<style>
    .nav-item:hover{
        background-color: rgba(171, 255, 0, 1);
    }
</style>
{{-- coupons --}}

<div class="nav-item {{ $segment1 == 'bookings' ? 'active' : '' }}">
    <a href="{{ url('admin/bookings') }}">
        <span class="fa-solid fa-calendar-days" style="font-size: 15px; padding-left:2px; padding-right:7px;"></span>
        {{ __('Bookings') }}</a>
</div>

{{-- coupons --}}
<div class="nav-item {{ $segment1 == 'coupons' ? 'active' : '' }}">
    <a class="d-flex align-items-baseline" href="{{ url('coupons') }}"><span class="fa-solid fa-percent" style="color: rgb(50 50 50 / 94%);font-size: 16px ;padding-right:10px; padding-left:2px;"></span>{{ __('Coupons') }}</a>
</div>
<div class="nav-item {{ $segment1 == 'complaint' ? 'active' : '' }}">
    <a class="d-flex align-items-baseline" href="{{ url('Complaintlogs') }}">
        <span class="fa-solid fa-box-tissue" style="color: rgb(50 50 50 / 94%);font-size: 15px ;padding-right:8.5px;"></span>{{ __('Complaint') }}</a>
</div>
<div class="nav-item  {{ $segment1 == 'transaction' ? 'active' : '' }}">
    <a class=" d-flex align-items-baseline" href="{{ url('/transaction') }}"><span class="fa-regular fa-credit-card" style="color: rgb(50 50 50 / 94%);font-size: 14px ;padding-right:8.5px;"></span>{{ __('Transaction') }}</a>
</div>
<div class="nav-item {{ $segment2 == 'RefundList' ? 'active' : '' }}">
    <a href="{{ url('admin/RefundList') }}" class="d-flex align-items-center "> 
            <span class="fa-solid fa-file-shield" style="color: rgb(50 50 50 / 94%);font-size: 14px ;padding-right:8px;"></span>
        <span>{{ __('Refund') }}</span></a>
</div>
{{-- ruff code --}}

{{-- ruff code --}}


<!--Subject-->
{{-- <div class="nav-item {{ $segment1 == 'level' ? 'active' : '' }}">
    <a href="{{ url('level') }}"><img src="{{ asset('img/sidebar_icons/subject.png') }}" alt="" width="14px"
            height="15px" style="padding-right: 3px">
        <span>{{ __('Level') }}</span></a>
</div> --}}

<!--Blog-->
{{-- <div class="nav-item {{ $segment1 == 'roles' ? 'active' : '' }}">
    <a href="{{ url('roles')  }}"><img src="{{ asset('img/sidebar_icons/blog.png') }}" alt="" width="14px"
            height="15px" style="padding-right: 3px">
        <span>{{ __('Roles') }}</span></a>
</div> --}}

<!--Tutor Money Request-->
{{-- <div class="nav-item {{ $segment1 == 'permission' ? 'active' : '' }}">
    <a href="{{ url('permission') }}"><img src="{{ asset('img/sidebar_icons/tutor_money_request.png') }}"
            alt="" width="15px" height="15px" style="padding-right: 3px">
        <span>{{ __('Permission') }}</span></a>


</div> --}}

<!--Pages-->
{{-- <div class="nav-item {{ $segment1 == 'pages' ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}"><img src="{{ asset('img/sidebar_icons/pages.png') }}" alt=""
            width="15px" height="15px" style="padding-right: 3px">
        <span>{{ __('Pages') }}</span></a>
</div> --}}

<!--Booking-->
{{-- <div class="nav-item {{ $segment1 == 'booking' ? 'active' : '' }}">
    <a href="{{ url('booking') }}"><img src="{{ asset('img/sidebar_icons/booking.png') }}" alt=""
            width="15px" height="15px" style="padding-right: 3px">
        <span>{{ __('Booking') }}</span></a>
</div> --}}

<!--Settings-->
{{-- <div class="nav-item {{ $segment1 == 'setting' ? 'active' : '' }}">
    <a href="{{ url('setting') }}"><img src="{{ asset('img/sidebar_icons/settings.png') }}" alt=""
            width="15px" height="15px" style="padding-right: 3px">
        <span>{{ __('Settings') }}</span></a>
</div> --}}

<div class="nav-item {{ $segment1 == 'setting' || $segment1 == 'newsletter' || $segment2 == 'terms_condition' || $segment2 == 'privacy_policy'  ? 'active open' : '' }} has-sub">
    <a href="#" id="setting-dropdown-toggle"style="display: flex; align-items: center ;">
        
        <i class="fa-solid fa-gear"style="color: rgb(50 50 50 / 94%);font-size: 15px;"></i>
        <span>Setting</span>
    </a>
    <div class="submenu-content" id="setting-dropdown-content">
        <!-- Only those with manage_user permission will get access -->
        <a href="{{ route('website') }}" class="d-flex align-items-center menu-item {{ $segment2 == 'pages' ? 'active' : '' }}">
            <span class="fa-solid fa-pager"  style="color: rgb(50 50 50 / 94%);font-size: 15px; padding-left:1px; padding-right:8px;"></span>
            Website</a>
        <a href="{{ route('bloglist') }}" class=" d-flex align-items-center menu-item {{ $segment2 == 'blog' ? 'active' : '' }}">
            <span class="fa-solid fa-newspaper" style="color: rgb(50 50 50 / 94%);font-size: 15px ; padding-left:1px;padding-right:8px;"></span>
            Blogs</a>
            <a href="{{ route('newsletter.list') }}" class="menu-item {{ $segment1 == 'newsletter' ? 'active' : '' }}">
             
                <span class="fa-solid fa-envelopes-bulk" style="color: rgb(50 50 50 / 94%);font-size: 14px;padding-right:6px;"></span>Newsletter</a>
                <a href="{{ route('commentlist') }}" class=" d-flex align-items-center menu-item {{ $segment2 == 'blog-comments' ? 'active' : '' }}">
            <span class="fa-solid fa-comments"  style="color: rgb(50 50 50 / 94%);font-size: 14px ;padding-right:6px;"></span>
            Comments</a>
            
            
            <a href="{{ url('admin/terms_condition') }}" class=" d-flex align-items-center menu-item {{ $segment2 == 'terms_condition' ? 'active' : '' }}">
            <span class="fa-solid fa-file-shield"  style="color: rgb(50 50 50 / 94%);font-size: 15px ;padding-left:2px;padding-right:6px;"></span>
            Terms Conditions</a>
            
            
            <a href="{{ url('admin/privacy_policy') }}" class=" d-flex align-items-center menu-item {{ $segment2 == 'privacy_policy' ? 'active' : '' }}">
            <span class="fa-solid fa-file-invoice"  style="color: rgb(50 50 50 / 94%);font-size: 16px ;padding-left:2px;padding-right:12px;"></span>
            Privacy policy</a>
            
        {{-- <a href="{{ route('documentTypes') }}" class="menu-item {{ $segment2 == 'document_types' ? 'active' : '' }}">Document Types</a> --}}
    </div>
</div>




<div class="nav-item {{ $segment1 == 'reviews' || $segment1 == 'student' || $segment1 == 'tutor' || $segment1 == 'parent'  ? 'active open' : '' }} has-sub">
    <a href="#" id="setting-dropdown-toggle" style="display: flex; align-items: start ;">
        <!--<img src="{{ asset('img/sidebar_icons/settings.png') }}" alt="" width="15px" height="15px" style="padding-right: 3px">-->
        <span class="fa-solid fa-ranking-star" style="color: rgb(50 50 50 / 94%);font-size: 14px ;padding-right:8px;"></span>
        <span>Reviews</span>
    </a>
    <div class="submenu-content" id="setting-dropdown-content">
        <!-- Only those with manage_user permission will get access -->
        <a href="{{ url('reviews/student') }}" class="d-flex align-items-center menu-item {{ $segment2 == 'student' ? 'active' : '' }}">
            <!--<i class="fa-solid fa-pager"  style="color: rgb(50 50 50 / 94%);font-size: 15px;"></i>-->
            <img src="{{ asset('img/sidebar_icons/review image 3.png')}}" alt="" width="20px" height="20px" style="padding-right: 5px">
            <span>Student Reviews</span></a>
        <a href="{{ url('reviews/tutor') }}" class=" d-flex align-items-center menu-item {{ $segment2 == 'tutor' ? 'active' : '' }}">
            <!--<i class="fa-solid fa-newspaper" style="color: rgb(50 50 50 / 94%);font-size: 15px;"></i>-->
            <img src="{{ asset('img/sidebar_icons/review image 3.png')}}" alt="" width="20px" height="20px" style="padding-right: 5px">
            <span>Tutor Reviews</span></a>
        <a href="{{ url('reviews/parent') }}" class=" d-flex align-items-center menu-item {{ $segment2 == 'parent' ? 'active' : '' }}">
            
                <!--<i class="fa-solid fa-newspaper" style="color: rgb(50 50 50 / 94%);font-size: 15px;"></i>-->
                <img src="{{ asset('img/sidebar_icons/review image 3.png')}}" alt="" width="20px" height="20px" style="padding-right: 5px">
            <span>Parent Reviews</span></a>
    </div>
</div>



<div class="nav-item {{ $segment1 == 'subjects' ? 'active' : '' }}">
    <a class="d-flex align-items-baseline" href="{{ url('subjects') }}"><i class="fa-solid fa-book" style="color: rgb(50 50 50 / 94%);font-size: 15px ;padding-right:2px;"></i>

        <span>{{ __('Subject') }}</span></a>
</div>

<!--Reviews-->
<div class="nav-item {{ $segment1 == 'ActivityLogs' ? 'active' : '' }}">
    <a href="{{ url('ActivityLogs') }}" class="d-flex align-items-center "> 
            <span class="fa-solid fa-file-shield" style="color: rgb(50 50 50 / 94%);font-size: 14px ;padding-right:8px;"></span>
        <span>{{ __('ActivityLogs') }}</span></a>
</div>



<!--Payments-->
<!--<div class=" nav-item {{ $segment1 == 'payments' ? 'active' : '' }}">-->
<!--    <a href="{{ route('dashboard') }}"><img src="{{ asset('img/sidebar_icons/payments.png') }}" alt=""-->
<!--            width="15px" height="15px" style="padding-right: 3px">-->
<!--        <span>{{ __('Payments') }}</span></a>-->
<!--</div>-->

<!--Reports-->
{{-- <div class="nav-item {{ $segment1 == 'reports' ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}"><img src="{{ asset('img/sidebar_icons/reports.png') }}" alt=""
            width="15px" height="15px" style="padding-right: 3px">
        <span>{{ __('Reports') }}</span></a>
</div> --}}

<!--Notification-->
{{-- <div class="nav-item {{ $segment1 == 'notification' ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}"><img src="{{ asset('img/sidebar_icons/notification.png') }}" alt=""
            width="15px" height="15px" style="padding-right: 3px">
        <span>{{ __('Notification') }}</span></a>
</div> --}}

<script>
$(document).ready(function() {
    $('#setting-dropdown-toggle').click(function(e) {
        e.preventDefault();
        $('#setting-dropdown-content').toggleClass('show');
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#setting-dropdown-toggle, #setting-dropdown-content').length) {
            $('#setting-dropdown-content').removeClass('show');
        }
    });
});
</script>




