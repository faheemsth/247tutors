<style>
.submenu-content .menu-item:hover{
        background-color: rgba(171, 254, 16, 1) !important;
        color: black !important ;
    }
</style>


<div class="app-sidebar colored">
    <div class="sidebar-header">
        <a class="header-brand" href="{{ route('dashboard') }}">
            <div class="logo-img">
                <img height="30" src="{{ asset('img/sidebar_icons/24_7_logo.png') }}" class="header-brand-img"
                    title="TUTOR">
            </div>
        </a>
    </div>

    @php
        $segment1 = request()->segment(1);
        $segment2 = request()->segment(2);
    @endphp

    <div class="sidebar-content">
        <div class="nav-container">
            <nav id="main-menu-navigation" class="navigation-main">
                <div class="nav-item {{ $segment1 == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}"><img src="{{ asset('img/sidebar_icons/dashboard.png') }}"
                            alt="" width="15px" height="15px" style="padding-right: 3px">
                        <span>{{ __('Dashboard') }}</span></a>
                </div>


                {{-- <div class="nav-item {{ $segment1 == 'users' ? 'active' : '' }}">
                    <a href="{{ url('users') }}"><img src="{{ asset('img/sidebar_icons/dashboard.png') }}"
                            alt="" width="15px" height="15px" style="padding-right: 3px">
                        <span>{{ __('Users') }}</span></a>
                </div> --}}

                 <div
                    class="nav-item {{ $segment1 == 'tutors' || $segment1 == 'organizations' || $segment1 == 'users' || $segment1 == 'parents' || $segment1 == 'students' || $segment1 == 'user' || $segment1 == 'interview' ? 'active open' : '' }} has-sub">
                    <a href="#" id="user-dropdown-toggle">
                        <img src="{{ asset('img/sidebar_icons/pngwing_users.png') }}" alt=""
                            width="15px" height="15px" style="padding-right: 3px">
                        <span>{{ ('Users') }}</span></a>
                    <div class="submenu-content">
                        <!-- only those have manage_user permission will get access -->
                        @can('manage_user')
                            <a href="{{ url('students') }}"
                                class="menu-item {{ $segment1 == 'students' ? 'active' : '' }} d-flex align-items-center">
                                <i class="fa-solid fa-user-tie ps-1"  style="color: rgba(80, 80, 80, 0.87);font-size: 15px;"></i>
                                {{('Students') }}</a>

                            <a href="{{ url('tutors') }}"
                                class="menu-item {{ $segment1 == 'tutors' ? 'active' : '' }} d-flex align-items-center">
                               <i class="fa-solid fa-user-group" style="color: rgba(80, 80, 80, 0.87);font-size: 15px;"></i>
                                {{('Tutors') }}</a>

                            <a href="{{ url('interview') }}"
                                class="menu-item {{ $segment1 == 'interview' ? 'active' : '' }} d-flex align-items-center">
                               <i class="fa-solid fa-people-arrows" style="color: rgba(80, 80, 80, 0.87);font-size: 15px;"></i>
                                {{('Interviews') }}</a>
                        @endcan
                        <!-- only those have manage_role permission will get access -->
                        @can('manage_roles')
                            <a href="{{ url('organizations') }}"
                                class="menu-item {{ $segment1 == 'organizations' ? 'active' : '' }} d-flex align-items-center">
                                <i class="fa-solid fa-users-line" style="color: rgba(80, 80, 80, 0.87);font-size: 15px;"></i>
                                {{('Organizations') }}</a>
                        @endcan
                        <!-- only those have manage_permission permission will get access -->
                        @can('manage_permission')
                            <a href="{{ url('parents') }}"
                                class="menu-item {{ $segment1 == 'parents' ? 'active' : '' }} d-flex align-items-center">
                                <i class="fa-solid fa-users" style="color: rgba(80, 80, 80, 0.87);font-size: 15px;"></i>
                                {{('Parents') }}</a>
                        @endcan
                    </div>
                </div>


                <!-- Include demo pages inside sidebar start-->
                @include('pages.sidebar-menu')
                <!-- Include demo pages inside sidebar end-->

            </nav>

        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#user-dropdown-toggle').click(function(e) {
        e.preventDefault();
        $('#user-dropdown-content').toggleClass('show');
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#user-dropdown-toggle, #user-dropdown-content').length) {
            $('#user-dropdown-content').removeClass('show');
        }
    });
});
</script>
