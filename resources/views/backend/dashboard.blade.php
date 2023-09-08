@extends('layouts.app')
@section('title')
    ATS - Dashboard
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dashboard</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="fa fas fa-home"></i></a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            @if (session('error'))
                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                    <div class="text-white">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-primary border-0 bg-primary alert-dismissible fade show">
                    <div class="text-white">{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <section class="mb-4 mb-lg-5">
                @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
                    @php
                        $class="col-lg-3 col-md-3 col-sm-6 col-xs-12";
                    @endphp
                @endcanany
                @can('isRecruiter')
                    @php    
                        $class="col-lg-4 col-md-4 col-sm-6 col-xs-12";
                    @endphp
                @endcan
                <div class="row">
                    @canany(['isAdmin','isAccountManager','isTeamLead','isCompanyAdmin'])
                        <div class="{{$class}}">
                            <div class="card-widget h-100">
                                <div class="card-widget-body">
                                    <div class="dot me-3 bg-indigo"></div>
                                    <div class="text">
                                        <h6 class="mb-0">Clients</h6>
                                        <span class="text-gray-500">{{getClientsCount()}}</span> / 
                                        <span class="text-gray-500">+{{getLastWeekClientsCount()}} from last week</span>
                                    </div>
                                    <div class="icon text-white bg-indigo"><i class="fas fa-user-plus"></i></div>
                                </div>
                            </div>
                        </div>
                    @endcanany
                    <div class="{{$class}}">
                        <div class="card-widget h-100">
                            <div class="card-widget-body">
                                <div class="dot me-3 bg-indigo"></div>
                                <div class="text">
                                    <h6 class="mb-0">Candidates</h6>
                                    <span class="text-gray-500">{{getCandidatesCount()}}</span> / 
                                    <span class="text-gray-500">+{{getLastWeekCandidatesCount()}} from last week</span>
                                </div>
                                <div class="icon text-white bg-indigo"><i class="fas fa-user-check"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="{{$class}}">
                        <div class="card-widget h-100">
                            <div class="card-widget-body">
                                <div class="dot me-3 bg-indigo"></div>
                                <div class="text">
                                    <h6 class="mb-0">Job Opportunities</h6>
                                    <span class="text-gray-500">{{getJobOpportunitiesCount()}}</span> / 
                                    <span class="text-gray-500">+{{getLastWeekJobOpportunitiesCount()}} from last week</span>
                                </div>
                                <div class="icon text-white bg-indigo"><i class="fas fas fa-plus-circle"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="{{$class}}">
                        <div class="card-widget h-100">
                            <div class="card-widget-body">
                                <div class="dot me-3 bg-indigo"></div>
                                <div class="text">
                                    <h6 class="mb-0">Job Submissions</h6>
                                    <span class="text-gray-500">{{getSubmissionsCount()}}</span> / 
                                    <span class="text-gray-500">+{{getLastWeekSubmissionsCount()}} from last week</span>
                                </div>
                                <div class="icon text-white bg-indigo"><i class="fas fas fas fa-rss"></i></div>
                            </div>
                        </div>
                    </div>
                </div><p> </p>
            </section>
            <section class="mb-4 mb-lg-5">
                <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Pipeline Summary</h2>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart1"></canvas>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart2"></canvas>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart3"></canvas>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart4"></canvas>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart5"></canvas>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart6"></canvas>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart7"></canvas>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                        <canvas class="mt-4" id="chart8"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <p> </p>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Upcoming Interviews</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>Candidate</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                </tr>
                                @foreach (getUpComingInterviews() as $item)
                                    <tr>
                                        <td>{{$item->candidate?->candidate_name}}</td>
                                        <td>{{$item->client?->client_name}}</td>
                                        <td>{{$item->from_date}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Completed Interviews</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>Candidate</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                </tr>
                                @foreach (getCompletedInterviews() as $item)
                                    <tr>
                                        <td>{{$item->candidate?->candidate_name}}</td>
                                        <td>{{$item->client?->client_name}}</td>
                                        <td>{{$item->from_date}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div><p> </p>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Activity Logs</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                @foreach (getUserActivityLogs() as $item)
                                    <tr>
                                        <td>
                                            {{getUserName($item->causer_id)}} {{$item->event}} 
                                            @if ($item->subject_type == 'App\Models\Candidate')
                                                a Candidate @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\User')
                                                an User @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\Client')
                                                a Client @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\Interview')
                                                an Interview @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\JobOpportunity')
                                                a Job Opportunity @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\Submission')
                                                a Job Submission @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\EndClient')  
                                                an End Client @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\PricingPlan')  
                                                a Pricing Plan @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\Company')  
                                                a Company @ {{$item->created_at->diffForHumans()}}
                                            @elseif ($item->subject_type == 'App\Models\Invoice')  
                                                an Invoice @ {{$item->created_at->diffForHumans()}}
                                            @elseif($item->subject_type == 'App\Models\AdditionalAttachment')
                                                an Attachment @ {{$item->created_at->diffForHumans()}}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div><p> </p>
        </div>
    </div>
@endsection
@section('javascripts')
    <!-- Init Charts on Charts page-->
    <script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/js/charts-defaults.js')}}"></script>
    <script>
        function drawChart() {
            var internalInterviews='{{getInternalInterviewCounts()}}';
            var generalInterviews='{{getGeneralInterviewCounts()}}';
            var onlineInterviews='{{getOnlineInterviewCounts()}}';
            var phoneInterviews='{{getPhoneInterviewCounts()}}';
            var level1Interviews='{{getLevel1InterviewCounts()}}';
            var level2Interviews='{{getLevel2InterviewCounts()}}';
            var level3Interviews='{{getLevel3InterviewCounts()}}';
            var level4Interviews='{{getLevel4InterviewCounts()}}';
            var totalInterviewCount='{{getTotalInterviewCounts()}}';
            const donut1 = new Chart(document.getElementById("chart1"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["Internal", "Total"],
                    datasets: [
                        {
                            data: [internalInterviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.blue, "#eee"],
                            hoverBackgroundColor: [window.colors.blue, "#eee"],
                        },
                    ],
                },
            });
            const donut2 = new Chart(document.getElementById("chart2"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["General", "Total"],
                    datasets: [
                        {
                            data: [generalInterviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.green, "#eee"],
                            hoverBackgroundColor: [window.colors.green, "#eee"],
                        },
                    ],
                },
            });
            const donut3 = new Chart(document.getElementById("chart3"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["General", "Total"],
                    datasets: [
                        {
                            data: [onlineInterviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.purple, "#eee"],
                            hoverBackgroundColor: [window.colors.purple, "#eee"],
                        },
                    ],
                },
            });
            const donut4 = new Chart(document.getElementById("chart4"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["Phone", "Total"],
                    datasets: [
                        {
                            data: [phoneInterviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.red, "#eee"],
                            hoverBackgroundColor: [window.colors.red, "#eee"],
                        },
                    ],
                },
            });
            const donut5 = new Chart(document.getElementById("chart5"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["Level 1", "Total"],
                    datasets: [
                        {
                            data: [level1Interviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.yellow, "#eee"],
                            hoverBackgroundColor: [window.colors.yellow, "#eee"],
                        },
                    ],
                },
            });
            const donut6 = new Chart(document.getElementById("chart6"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["Level 2", "Total"],
                    datasets: [
                        {
                            data: [level2Interviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.pink, "#eee"],
                            hoverBackgroundColor: [window.colors.pink, "#eee"],
                        },
                    ],
                },
            });
            const donut7 = new Chart(document.getElementById("chart7"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["Level 3", "Total"],
                    datasets: [
                        {
                            data: [level3Interviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.cyan, "#eee"],
                            hoverBackgroundColor: [window.colors.cyan, "#eee"],
                        },
                    ],
                },
            });
            const donut8 = new Chart(document.getElementById("chart8"), {
                type: "doughnut",
                options: {
                    cutoutPercentage: 90,
                    legend: {
                        display: true,
                    },
                },
                data: {
                    labels: ["Level 4", "Total"],
                    datasets: [
                        {
                            data: [level4Interviews, totalInterviewCount],
                            borderWidth: [0, 0],
                            backgroundColor: [window.colors.indigo, "#eee"],
                            hoverBackgroundColor: [window.colors.indigo, "#eee"],
                        },
                    ],
                },
            });
            
        }
        drawChart();
    </script>
@endsection