@extends('layouts.app')
@section('content')
@include('layouts.navbar')
<style>
    a{
        text-decoration: none;
    }
    p{
        margin: 16px 0px;
        font-size: 17px;
    }
</style>
<div class="container-fluid mt-5 my-lg-5 p-5">
    <h1 class="fw-bold fs-1 " id="text-color">Terms and Conditions</h1>
</div>
<div class="container-fluid px-5 mb-5 pb-5">
    <div class="row">
        <div class="col-lg-4 border border-subtle">
            <h5 class="text-warning-emphasis my-4 mx-3" id="text-color">Terms and Conditions</h5>
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
