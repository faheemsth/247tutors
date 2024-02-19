@extends('layouts.main')
@section('title', 'Users')

<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

@push('head')
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script type="text/javascript" src="../js/languages/ro.js"></script>
@endpush
@section('content')
    <div class="page-header">
        <div class="container-fluid">
        <div class="row align-items-end">
            <div class="col-11 col-lg-8 mb-3 mb-md-0">
                <div class="page-header-title">
                    <i class="fa-solid fa-newspaper bg-blue"></i>
                    <div class="d-inline">
                        <h5>{{ __('Blog') }}</h5>
                        <span>{{ __('List of Blogs') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-11 col-lg-4">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">{{ __('Settings') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('bloglist') }}">{{ __('Blog') }}</a>
                        </li>

                    </ol>
                </nav>
            </div>
        </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            @include('include.message')
        </div>
    </div>




            <div class="container">
                <div class="row">
                    <!-- start message area-->
                    @include('include.message')
                    <!-- end message area-->
                    <div class="col-md-12 col-12 pe-0 pe-md-2 user-table-data">
                        <div class="card p-md-3 p-3">
                            <div class="card-header justify-content-between">
                                <h4>{{ __('Blogs') }}</h4>

                                <!--<form method="GET" action="" class="col-md-6 d-flex justify-content-between align-items-center gap-2">-->
                                <!--    <select name="category" id="status" class="col-md-6 select2 form-select">-->
                                <!--        <option value="">All Search</option>-->
                                <!--        <option value="3" {{ !empty($_GET['status']) && $_GET['status'] == '3' ? 'selected':'' }}>Tutor</option>-->
                                <!--        <option value="4" {{ !empty($_GET['status']) && $_GET['status'] == '4' ? 'selected':'' }}>Student</option>-->
                                <!--        <option value="5" {{ !empty($_GET['status']) && $_GET['status'] == '5' ? 'selected':'' }}>Parent</option>-->
    
                                <!--    </select>-->
                                <!--    <input type="text" name="search" value="{{ $_GET['search'] ?? '' }}" class="form-control" placeholder="Search">-->
                                <!--    <button type="submit" class="btn btn-primary">Search</button>-->
                                <!--</form>-->
                                
                                <div class="btn btn-primary px-2 py-2" style="height: max-content;">
                                    <a href="/blog/create" class="text-light"><i
                                            class="fa-solid fa-user-plus m-auto"></i></a>
                                </div>

                            </div>
                            <div class="card-body" style="overflow:scroll">
                                <table id="reviewStudents" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Sr.No') }}</th>
                                            <th>{{ __('Slug') }}</th>
                                            <th>{{ __('Title') }}</th>
                                            <th>{{ __('Content') }}</th>
                                            <th>{{ __('Category') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($blogs as $key => $blog)
                                            <tr>
                                                <td style="border-bottom: .5px solid black;">{{ $key + 1 }}</td>
                                                <td style="border-bottom: .5px solid black;">{{ $blog->slug }}</td>
                                                <td style="border-bottom: .5px solid black;">{{ $blog->title }}</td>
                                                <td style="border-bottom: .5px solid black;">
                                                    
                                                    <?php
                                                    
                                                    $string = strip_tags($blog->content);
                                                    if (strlen($string) > 500) {
                                                    
                                                        // truncate string
                                                        $stringCut = substr($string, 0, 400);
                                                        $endPoint = strrpos($stringCut, ' ');
                                                    
                                                        //if the string doesn't contain any space then it will cut without word basis.
                                                        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                        $string .= '...';
                                                    }
                                                    echo $string;
                                                    ?>
                                                    <!--{!! $blog->content !!}-->
                                                </td>
                                                <td style="border-bottom: .5px solid black;">
                                                    @php
                                                        if($blog->category_id == '3')
                                                        {
                                                           echo "Tutor";
                                                        }elseif($blog->category_id == '4'){
                                                            echo "Student";
                                                        }else{
                                                            echo "Parent";
                                                        }
                                                    @endphp
                                                </td>
                                                <td style="border-bottom: .5px solid black;">{{ $blog->status }}</td>
                                                <td style="border-bottom: .5px solid black;">
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ url('blog/update?id=') . $blog->id }}"
                                                            class="btn btn-primary btn-sm" style="height: max-content;"><i
                                                                class="fa-regular fa-pen-to-square m-auto"></i></a>
                                                        <a href="{{ url('blog/delete?id=') . $blog->id }}"
                                                            class="btn btn-danger btn-sm" style="height: max-content;"><i
                                                                class="fa-solid fa-trash-can m-auto"></i></a>
                                                    </div>
                                                </td>

                                            </tr>
                                        @empty
                                            <tr>
                                                <td>Record not found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{ $blogs->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"/>
                        <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.5/datatables.min.js"></script>
                        <script>
                            $(document).ready(function(){
                                $('#reviewStudents').DataTable();
                            });
                        </script>
@endsection
