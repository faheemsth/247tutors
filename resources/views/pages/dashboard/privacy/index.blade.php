@extends('layouts.main')
@section('title', 'Privacy & Policy')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endpush
    <style>
     table tr td>p[data-f-id='pdf'] {
    display: none !important ;
}

    </style>


    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="page-header-title">
                        <i class="fa-solid fa-file-invoice bg-blue"></i>
                        <div class="d-inline">
                            <h5>{{ __('Privacy & Policy') }}</h5>
                            <span>{{ __('List of Privacy & Policy') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-3 mt-md-0">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Privacy & Policy') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="col-md-12  user-table-data col-12 pe-0 pe-md-2">
                <div class="card  p-md-3 p-2">
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Privacy & Policy') }}</h3>
                        <a href="{{ url('add/terms/privacy_policy') }}" class="btn btn-primary px-2 py-1"><i class="fa fa-plus"></i></a>
                    </div>
                    <div class="card-body" style="overflow: scroll;">
                        <table id="reviewStudents" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Sr.No') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Content') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($TermsAndCondition)
                                    @foreach($TermsAndCondition as $key => $TermsAndCon)
                                        <tr>
                                            <th style="border-bottom: .5px solid black;">{{ $key+1 }}</th>
                                            <td style="border-bottom: .5px solid black;">

                                                <?php
                                                    
                                                    $string = strip_tags( $TermsAndCon->type);
                                                    if (strlen($string) > 15) {
                                                        $stringCut = substr($string, 0, 15);
                                                        $endPoint = strrpos($stringCut, ' ');
                                                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                        $string .= '...';
                                                    }
                                                    echo $string;
                                                 ?>
                                                
                                                </td>
                                            <td style="border-bottom: .5px solid black;">
                                                <?php
                                                    
                                                    $string = strip_tags( $TermsAndCon->content);
                                                    if (strlen($string) > 15) {
                                                        $stringCut = substr($string, 0, 15);
                                                        $endPoint = strrpos($stringCut, ' ');
                                                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                        $string .= '...';
                                                    }
                                                    echo $string;
                                                 ?>
                                                
                                                
                                                </td>
                                            
                                             <td style="border-bottom: .5px solid black;" class="d-flex justify-content-center  align-items-center gap-2 text-white">
                                                <a href="{{ url('delete/terms/privacy_policy') . '/' . $TermsAndCon->id }}"
                                                    class="btn btn-danger p-2 ">
                                                    <i class="fa-solid fa-trash" style="font-size: 14px;"></i></a>
                                                <a class="btn btn-primary p-2"
                                                   href="{{ url('update/terms/privacy_policy') . '/' . $TermsAndCon->id }}"><i
                                                        class="fa-solid fa-edit" style="font-size: 14px;"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="4">Record not found</td>
                                    </tr>
                               @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('js/custom.js') }}"></script>
    @endpush
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('#reviewStudents').DataTable();
                            });
                        </script>
@endsection
