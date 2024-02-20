@if (Auth::check())
@if (Auth::user()->role_id == '4')
    @include('layouts.studentnav')
@elseif (Auth::user()->role_id == '3')
    @include('layouts.tutornav')
@elseif (Auth::user()->role_id == '5')
    @include('layouts.parentnav')
@elseif (Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
    @include('layouts.navbar')
@elseif (Auth::user()->role_id == '6')
    @include('layouts.orgnav')
@endif
@else
@include('layouts.navbar')
@endif
