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
                                    <h6 class="mb-0">Total Clients</h6>
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
                                <h6 class="mb-0">Total Candidates</h6>
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
                                <h6 class="mb-0">Total Job Opportunities</h6>
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
                                <h6 class="mb-0">Total Job Submissions</h6>
                                <span class="text-gray-500">{{getSubmissionsCount()}}</span> / 
                                <span class="text-gray-500">+{{getLastWeekSubmissionsCount()}} from last week</span>
                            </div>
                            <div class="icon text-white bg-indigo"><i class="fas fas fas fa-rss"></i></div>
                        </div>
                    </div>
                </div>
            </div><p> </p>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div id="chart4"></div>
                        </div>
                    </div>
                </div>
            </div><p> </p>
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
    <script src="{{asset('assets/css/apexcharts-bundle/js/apexcharts.min.js')}}"></script>
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
            // chart 4
            var options = {
                series: [{
                    name: 'Interviews',
                    data: [internalInterviews, generalInterviews, onlineInterviews, phoneInterviews, level1Interviews, level2Interviews, level3Interviews, level4Interviews]
                }],
                annotations: {
                    points: [{
                        x: 'Bananas',
                        seriesIndex: 0,
                        label: {
                            borderColor: '#775DD0',
                            offsetY: 0,
                            style: {
                                color: '#fff',
                                background: '#775DD0',
                            },
                        }
                    }]
                },
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        columnWidth: '30%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2
                },
                grid: {
                    row: {
                        colors: ['#fff', '#f2f2f2']
                    }
                },
                title: {
                    text: 'Pipelines',
                    align: 'left',
                    style: {
                        fontSize: '14px'
                    }
                },
                xaxis: {
                    labels: {
                        rotate: -45
                    },
                    categories: ['Internal Interviews', 'General Interviews', 'Online Interviews', 'Phone Interviews', 'Level 1 Interviews', 'Level 2 Interviews',
                        'Level 3 Interviews', 'Level 4 Interviews'
                    ],
                    tickPlacement: 'on'
                },
                yaxis: {
                    title: {
                        text: 'Interviews',
                    },
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 0.85,
                        opacityTo: 0.85,
                        stops: [50, 0, 100]
                    },
                },
                tooltip: {
                    y: {
                    formatter: function(val) {
                        return val + "/" + totalInterviewCount
                    },
                    title: {
                        formatter: function (seriesName) {
                            return seriesName
                        }
                    }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart4"), options);
            chart.render();
        }
        drawChart();
    </script>
@endsection