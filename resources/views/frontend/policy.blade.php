@extends('layouts.app')
@section('content')
@include('layouts.navbar')
<style>
    a{
        text-decoration: none;
    }
</style>
<div class="container-fluid mt-5 my-md-5 p-3 p-md-5">
    <h2 class="fw-bold fs-1 ">Privacy and Cookies</h2>
    <h5 class="fw-bold mt-4">For school and university programmes please <a href="#">click here</a></h5>
</div>
<div class="container-fluid px-md-5 px-4 mb-5 pb-5">
    <div class="row">
        <div class="col-4 border border-subtle d-none d-md-inline-block">
            <h5 class="text-warning-emphasis my-4 mx-3">Privacy Policy</h5>
            <ol class="mx-2 ">
                @if(!empty($TermsAndCondition))
                    @foreach($TermsAndCondition as $TermsAndCond)
                        <li class="p-2"><a id="button{{ $TermsAndCond->id }}" class="toggle-button " style="cursor:pointer">{{ $TermsAndCond->type }}</a></li>
                    @endforeach
                @endif

            </ol>
        </div>
        @if(!empty($TermsAndCondition))
            @foreach($TermsAndCondition as $key => $TermsAndCond)
                <div class="col-lg-8 col-12 px-lg-4 py-1 toggle-div" style="display: {{ $key == 0 ? '' : 'none' }};" id="div{{ $TermsAndCond->id }}">
                    {!! $TermsAndCond->content !!}
                </div>
            @endforeach

       @endif
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.body.addEventListener('click', function(event) {
            if (event.target.classList.contains('toggle-button')) {
                var index = event.target.id.replace('button', '');
                toggleDiv('div' + index);
            }
        });

        function toggleDiv(clickedDivId) {
            document.querySelectorAll('.toggle-div').forEach(function(div) {
                div.style.display = (div.id === clickedDivId) ? 'block' : 'none';
            });
        }
    });
</script>
@endsection
