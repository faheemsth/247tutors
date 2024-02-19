@extends('layouts.main')
@section('title', 'Dashboard')
@section('content')
    <!-- push external head elements to head -->
    @push('head')
        <link rel="stylesheet" href="{{ asset('plugins/weather-icons/css/weather-icons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/owl.carousel/dist/assets/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/chartist/dist/chartist.min.css') }}">
    @endpush


    @push('script')
        <script src="{{ asset('plugins/owl.carousel/dist/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('plugins/chartist/dist/chartist.min.js') }}"></script>
        <script src="{{ asset('plugins/flot-charts/jquery.flot.js') }}"></script>
         <!--<script src="{{ asset('plugins/flot-charts/jquery.flot.categories.js') }}"></script> -->
        <script src="{{ asset('plugins/flot-charts/curvedLines.js') }}"></script>
        <script src="{{ asset('plugins/flot-charts/jquery.flot.tooltip.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script src="https://cdn.anychart.com/releases/8.11.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.11.1/js/anychart-pie.min.js"></script>

        <script src="{{ asset('plugins/amcharts/amcharts.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/serial.js') }}"></script>
        <script src="{{ asset('plugins/amcharts/themes/light.js') }}"></script>

        <!--
                        <script src="{{ asset('js/widget-statistic.js') }}"></script>
                        <script src="{{ asset('js/widget-data.js') }}"></script>
                        <script src="{{ asset('js/dashboard-charts.js') }}"></script>
                -->

        <?php
        $roles = [3, 4, 5, 6];
        $years = [2021, 2022, 2023, 2024];
        $data = [];
        
        foreach ($roles as $role) {
            foreach ($years as $year) {
                $key = "{$role}_{$year}";
                $data[$key] = App\Models\User::where('role_id', $role)
                    ->whereYear('created_at', '=', $year)
                    ->count();
            }
        }
        ?>
        <!--old bar chart-->
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            var data = <?php echo json_encode($data); ?>;

            google.charts.load('current', {
                'packages': ['bar']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var chartData = [
                    ['Year', 'Tutor', 'Parent', 'Student', 'Organizations']
                ];

                <?php foreach ($years as $year): ?>
                var row = ['<?php echo $year; ?>'];
                <?php foreach ($roles as $role): ?>
                var key = '<?php echo $role . '_' . $year; ?>';
                row.push(data[key]);
                <?php endforeach; ?>
                chartData.push(row);
                <?php endforeach; ?>

                var dataTable = google.visualization.arrayToDataTable(chartData);

                var options = {
                    chart: {
                        title: 'Yearly Users Analytics',
                        subtitle: 'Tutor, Parent, Organization and Student: 2023-2024',
                    }
                };

                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                chart.draw(dataTable, google.charts.Bar.convertOptions(options));
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!--old bar chart end-->
        
        <!--new bar chart-->
        <script>
            var options = {
          series: [{
          name: 'Tutor',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
          name: 'Student',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        },
         {
          name: 'Parent',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        },
        {
          name: 'Organization',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
        }],
          chart: {
          type: 'bar',
          height: 350
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          },
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },
        yaxis: {
          title: {
            // text: '$ (thousands)'
          }
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return "$ " + val + " thousands"
            }
          }
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
        </script>
        <!--new bar chart end -->



<?php
use Carbon\Carbon;

// tutors
$currentMonth = Carbon::now();
$labels = [];
$tutorData = []; // Initialize $tutorData array

for ($i = 6; $i >= 0; $i--) {
    $startOfMonth = $currentMonth
        ->copy()
        ->subMonths($i)
        ->startOfMonth();
    $endOfMonth = $currentMonth
        ->copy()
        ->subMonths($i)
        ->endOfMonth();

    $monthName = $startOfMonth->format('F');
    $labels[] = ucfirst($monthName); // Capitalize the first letter of the month name

    $tutorData['PKR' . $monthName] = App\Models\Booking::where('status', 'Completed')
        ->whereBetween('bookings.created_at', [$startOfMonth, $endOfMonth])
        ->join('transactions', 'transactions.booking_id', 'bookings.id')
        ->sum('transactions.amount');
}
?>


    <!--OLD DOUGHNUT CHART-->
        <script type="text/javascript">
            const chartData = {
                labels: <?php echo json_encode($labels); ?>,
                data: <?php echo json_encode(array_values($tutorData)); ?>,
            };

            const myChart = document.querySelector(".my-charts");
            const ul = document.querySelector(".programming-stats .details ul");

            new Chart(myChart, {
                type: "doughnut",
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: "Amount",
                        data: chartData.data,
                    }, ],
                },
                options: {
                    borderWidth: 10,
                    borderRadius: 2,
                    hoverBorderWidth: 0,
                    plugins: {
                        legend: {
                            display: false,
                        },
                    },
                },
            });

            const populateUl = () => {
                chartData.labels.forEach((l, i) => {
                    let li = document.createElement("li");
                    li.innerHTML = `${l}: <span class='percentage'>${chartData.data[i]}%</span>`;
                    ul.appendChild(li);
                });
            };

            populateUl();
        </script>
        <!--OLD DOUGHNUT CHART END-->
        
        <!--2new dounut chart-->
         <script>
      anychart.onDocumentReady(function () {  
        var data = anychart.data.set([
          ["Wimbledon", 8],
          ["Australian Open", 6],
          ["U.S. Open", 5],
          ["French Open", 1]
        ]);
        var chart = anychart
          .pie(data)
          .innerRadius("55%");
        chart.container("dochart1");
        chart.draw();
      });
    </script>
    @endpush
    <style>
        .card-animate:hover {
            transform: translateY(calc(-1.5rem / 5));
            box-shadow: 0 5px 10px #1e20251f;
        }

        .card-animate {
            transition: all .4s;
        }

        .avatar-title {
            align-items: center;
            /* background-color: #5ea3cb; */
            color: #fff;
            display: flex;
            font-weight: 500;
            height: 100%;
            justify-content: center;
            width: 100%;
        }

        .avatar-title i {
            font-size: 20px !important;
        }
        

    
    </style>
       <style type="text/css">      
       #dochart1 { 
        width: 100%; height: 100%; margin: 0; padding: 0; 
      } 
      .anychart-credits-text{
          display:none;
      }
      .anychart-credits-logo{
          display:none;
      }
    </style>
    

    <div class="h-100 px-3">
        <div class="row mb-3 pb-1">
            <div class="col-12">
                <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Good Morning, Super Admin!</h4>
                        <p class="text-muted mb-0 ">Lastest form 247Tutors.
                        </p>
                    </div>

                </div><!-- end card header -->
            </div>
            <!--end col-->
        </div>
        <!--end row-->

        <div class="row">
            <div class="col-xl-3 col-md-4 col-lg-4 ">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    <i class="fa-solid fa-arrow-up-wide-short"></i>
                                    Total Earnings
                                </p>
                            </div>
                            <div class="flex-shrink-0">

                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2"><span class="counter-value"
                                        data-target="">£0.00</span>
                                </h4>
                                <a href="" class="text-decoration-underline text-muted">View Net
                                    Earnings</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-success-subtle rounded fs-3">
                                    <i class="bx bx-dollar-circle text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-4 col-lg-4 ">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    <i class="fa-solid fa-people-group"></i>
                                    Organizations
                                </p>
                            </div>
                            <div class="flex-shrink-0">

                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2"><span class="counter-value"
                                        data-target="0">{{ $org->count() }}</span></h4>
                                <a href="{{ url('organizations') }}" class="text-decoration-underline text-muted">View All
                                    Organizations</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-info-subtle rounded fs-3">
                                    <i class="fa-solid fa-people-group"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-4 col-lg-4">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    <i class="fa fa-solid fa-building-columns"></i>
                                    Tutors
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                {{-- <h5 class="text-success fs-14 mb-0">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                    +29.08 %
                                </h5> --}}
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2"><span class="counter-value"
                                        data-target="">{{ $tutors->count() }}</span>
                                </h4>
                                <a href="{{ url('tutors') }}" class="text-decoration-underline text-muted">View All
                                    Tutors</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-warning-subtle rounded fs-3">
                                    <i class="bx bx-user-circle text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-3 col-md-4 col-lg-4">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                    Students
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                {{-- <h5 class="text-muted fs-14 mb-0">
                                    +0.00 %
                                </h5> --}}
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2"><span class="counter-value"
                                        data-target="0">{{ $students->count() }}</span>
                                </h4>
                                <a href="{{ url('students') }}" class="text-decoration-underline text-muted">View All
                                    Students</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                    <i class="bx bx-user-circle text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
            <div class="col-xl-3 col-md-4 col-lg-4">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    <i class="fa-solid fa-hands-holding-child"></i>
                                    Parents
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                {{-- <h5 class="text-muted fs-14 mb-0">
                                    +0.00 %
                                </h5> --}}
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2"><span class="counter-value"
                                        data-target="0">{{ $parents->count() }}</span>
                                </h4>
                                <a href="{{ url('parents') }}" class="text-decoration-underline text-muted">View All
                                    Parents</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                    <i class="bx bx-user-circle text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <!-- end col -->
            
            <div class="col-xl-3 col-md-4 col-lg-4">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body" style="height:125.5px;">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    <i class="fa-solid fa-calendar-plus"></i>
                                    Scheduled Booking
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                {{-- <h5 class="text-muted fs-14 mb-0">
                                    +0.00 %
                                </h5> --}}
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2 ">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="0">
                                        {{ $Scheduled->count() }}
                                    </span>
                                </h4>
                                <a href="{{ url('admin/bookings?status=Scheduled') }}"
                                    class="text-decoration-underline text-muted">View All
                                    Scheduled Bookings</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                    <i class="bx bx-user-circle text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <div class="col-xl-3 col-md-4 col-lg-4">
                <!-- card -->
                <div class="card card-animate">
                    <div class="card-body" style="height:125.5px;">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                    Cancelled Booking
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                {{-- <h5 class="text-muted fs-14 mb-0">
                                    +0.00 %
                                </h5> --}}
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2">
                                    <span class="counter-value" data-target="0">
                                        {{ $Cancelled->count() }}
                                    </span>
                                </h4>
                                <a href="{{ url('admin/bookings?status=Cancelled') }}"
                                    class="text-decoration-underline text-muted">View All
                                    Cancelled Bookings</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                    <i class="bx bx-user-circle text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <div class="col-xl-3 col-md-4 col-lg-4">
                <!-- card -->
                <div class="card card-animate ">
                    <div class="card-body" style="height:125.5px;">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 overflow-hidden">
                                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                <i class="fa-solid fa-calendar-check"></i>
                                    Completed Booking
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                {{-- <h5 class="text-muted fs-14 mb-0">
                                    +0.00 %
                                </h5> --}}
                            </div>
                        </div>
                        <div class="d-flex align-items-end justify-content-between mt-2">
                            <div>
                                <h4 class="fs-22 fw-semibold ff-secondary mb-2 ">
                                    <span class="counter-value" data-target="0">
                                        {{ $Completed->count() }}
                                    </span>
                                </h4>
                                <a href="{{ url('admin/bookings?status=Completed') }}"
                                    class="text-decoration-underline text-muted">View All
                                    Completed Bookings</a>
                            </div>
                            <div class="avatar-sm flex-shrink-0">
                                <span class="avatar-title bg-primary-subtle rounded fs-3">
                                    <i class="bx bx-user-circle text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
        </div>
    </div>

    <!--<div class="container-fluid px-0 mx-auto  ">-->
        <!--<div class="row  mt-1 mb-3 justify-content-center" style="gap:10px">-->
        <!--    <div class="col-md-10 col-lg-7 col-12 bg-white py-2">-->
                
        <!--        <div id="columnchart_material"style="width: 100%; height: 350px; background-color:transparent;"></div>-->
                
        <!--    </div>-->
        
    <!--        <div class="col-md-7 col-12 col-lg-4">-->
    <!--            <div class="bg-white p-3 h-100">-->
    <!--            <h4 class="chart-heading"-->
    <!--                style="    cursor: default;-->
    <!--user-select: none;-->
    <!---webkit-font-smoothing: antialiased;-->
    <!--font-family: Roboto;-->
    <!--font-size: 16px;color:#686868;">-->
    <!--                Monthly Income Analytics</h4>-->
    <!--            <p style="font-size:15px;color:gray;">Total Complete Booking Revenue: 2023-2024</p>-->
    <!--            <canvas class="my-charts" style="width:100%; height:300px"></canvas>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <!---->
    
    <!--new chart section-->
    <div class="container-fluid px-3 mb-3">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-8 my-2">
            <div class="card h-100 p-2">
                <div class=" py-2 px-3" style="line-height:1.3;">
                    <h6 class="card-title  fw-bold ">Yearly Users Analytics</h6>
                    <p class="text-muted">Tutor, Parent, Organization and Student : 2023 - 2024</p>
        
                </div>

                <div id="chart" style="height: 300px; width: 100%;"></div>
                
            </div>

        </div>

        <div class="col-12 col-md-12 col-lg-4 my-2 ">
            <div class="card h-100 p-2">
                <div class="px-3 pt-2 ">
                    <h6 class="card-title ">Total Complete Booking Revenue: 2023-2024</h6>
                </div>
                 <div id="dochart1"></div>
            </div>
        </div>
     </div>
    
    </div>
    <!--new chart section end-->

    <div class="container-fluid mx-0 px-3">
        <div class="row ">
            <!--<div class="col-xl-12 col-12 mb-3">-->
                 <!--<div id="regions_div" style="width: 100%;height:400px; "></div>-->
            <!-- </div>-->
            <div class="col-xl-8 col-md-12 col-lg-8 col-12">
                <div class="card px-1 px-md-3">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Recent Member's</h4>
                        <div class="flex-shrink-0">
                            <a href="{{ url('dowunloadPdf') }}" class="btn-soft-info btn px-2 py-1"
                                style="border: none;font-size: 13px;background-color: rgba(171, 254, 16, 1);">
                                <i class="ri-file-list-3-line align-middle"></i> Generate Report
                            </a>
                        </div>
                    </div><!-- end card header -->

                    <div class="card-body px-1 px-md-2">
                        <div class="table-responsive table-card">
                            <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                <thead class="text-muted table-light">
                                    <tr>
                                        <th scope="col">Member</th>
                                        {{-- <th scope="col">Institute</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Position</th> --}}
                                        <th scope="col">Status</th>
                                        {{-- <th scope="col">Rating</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($recents))
                                        @foreach ($recents as $recent)
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 m-2">

                                                        @if (!empty($recent->image) && file_exists(public_path(!empty($recent->image) ? $recent->image : '')))
                                                            <img src="{{ $recent->image }}" alt=""
                                                                width="50" height="50"
                                                                class="avatar-xs rounded-circle">
                                                        @else
                                                            @if ($recent->gender == 'Male')
                                                                <img src="{{ asset('assets/images/male.jpg') }}"
                                                                    alt="" width="50" height="50"
                                                                    class="avatar-xs rounded-circle">
                                                            @elseif($recent->gender == 'Female')
                                                                <img src="{{ asset('assets/images/female.jpg') }}"
                                                                    alt="" width="50" height="50"
                                                                    class="avatar-xs rounded-circle">
                                                            @else
                                                                <img src="{{ asset('assets/images/default.png') }}"
                                                                    alt="" width="50" height="50"
                                                                    class="avatar-xs rounded-circle">
                                                            @endif
                                                        @endif

                                                        {{-- <img src="{{asset(Auth::user()->image)}}" alt="" width="50" height="50" class="avatar-xs rounded-circle"> --}}
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        {{ $recent->first_name . '  ' . $recent->last_name }}</div>
                                                </div>
                                            </td>
                                            <td>{{ $recent->status }}</td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </tbody><!-- end tbody -->
                            </table><!-- end table -->
                            {{ $recents->links() }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
