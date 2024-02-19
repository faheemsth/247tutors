@extends('layouts.main')
@section('title', 'Transaction Logs')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/webicons/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @endpush
    <div class="container-fluid">
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="page-header-title">
                        <i class="fa-regular fa-credit-card bg-blue" style="margin-right:10px;"></i>
                        <div class="d-inline">
                            <h5>{{ __('Transaction') }}</h5>
                            <span>{{ __('List of Transaction Logs') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12 mt-4 mt-md-0">
                    <nav class="breadcrumb-container" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}"><i class="ik ik-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('Transaction Logs') }}</a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12  user-table-data col-12 pe-0 p-md-2">
                <div class="card p-md-3 p-2">
                    <div class="card-header justify-content-between">
                        <h3>{{ __('Transaction') }}</h3>
                    </div>
                    <div class="card-body" style="overflow: scroll;">
                       
                            <table id="reviewStudents" class="table table-bordered">
                                <thead class="student-table-details">
                                    <tr>
                                        <th>Sr No</th>
                                        <th>#Charge Id</th>
                                        <th>Bookind Id</th>
                                        <th>Amount</th>
                                        <th>Account Holder Name</th>
                                        <th>Card Type</th>
                                        <th>Post Code</th>
                                        <th>Address</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($transaction))
                                    @foreach ($transaction as $key => $transact)
                                    <tr>
                                        <td style="border-bottom: .5px solid black;">{{ $key+1 }}</td>
                                        <td style="border-bottom: .5px solid black;">
                                            
                                            {{ !empty($transact->charge_id) ? $transact->charge_id :'Wallet Type' }}
                                            
                                            </td>
                                        <td style="border-bottom: .5px solid black;">
                                            {{ optional(App\Models\Booking::find($transact->booking_id))->uuid  }}
                                        </td>
                                        <td style="border-bottom: .5px solid black;">

                                               @if ((int) $transact->amount == $transact->amount)
                                                   £{{ $transact->amount  }}.00 
                                               @else
                                               £{{ $transact->amount  }} 
                                               @endif
                                            
                                        </td>
                                        <td style="border-bottom: .5px solid black;">{{ $transact->account_holder_name  }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $transact->card_type	 }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $transact->postcode	 }}</td>
                                        <td style="border-bottom: .5px solid black;">{{ $transact->address1	 }}</td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>

                        
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
