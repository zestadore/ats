@extends('layouts.app')
@section('styles')
@endsection
@section('title')
    ATS - Dashboard
@endsection
@section('contents')
    <div class="container-fluid px-lg-4 px-xl-5">
        <div class="page-content">
            <div style="padding:5px;"><span style="float:right !important;font-weight:bold;">Hi, {{Auth::user()->first_name}} {{Auth::user()->last_name}}, Welcome to Ezizaas - ATS !<span>&nbsp;
                {{-- <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="float:right !important;">Dashboard options&nbsp;<i class="fas fa-cog"></i></button>
                <div class="dropdown-menu" style="">
                    <a class="dropdown-item" href="Javascript::void(0)">
                        <label class="switch">
                            <input type="checkbox" id="countsToggle" checked>
                            <span class="slider round"></span>
                        </label>
                        Counts
                    </a>
                    <a class="dropdown-item" href="Javascript::void(0)">
                        <label class="switch">
                            <input type="checkbox" id="pipelineToggle" checked>
                            <span class="slider round"></span>
                        </label>
                        Pipeline Summary
                    </a>
                    <a class="dropdown-item" href="Javascript::void(0)">
                        <label class="switch">
                            <input type="checkbox" id="interviewsToggle" checked>
                            <span class="slider round"></span>
                        </label>
                        Upcomming Interviews
                    </a>
                    <a class="dropdown-item" href="Javascript::void(0)">
                        <label class="switch">
                            <input type="checkbox" id="completedInterviewsToggle" checked>
                            <span class="slider round"></span>
                        </label>
                        Completed Interviews
                    </a>
                    <a class="dropdown-item" href="Javascript::void(0)">
                        <label class="switch">
                            <input type="checkbox" id="submissionsToggle" checked>
                            <span class="slider round"></span>
                        </label>
                        Recent Submissions
                    </a>
                    <a class="dropdown-item" href="Javascript::void(0)">
                        <label class="switch">
                            <input type="checkbox" id="activityLogsToggle" checked>
                            <span class="slider round"></span>
                        </label>
                        Activity Logs
                    </a>
                </div> --}}
            </div>
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
            <p> </p>
            <div class="dashboard">
                <span class="grid-stack-element" id="countsSection" draggable="true" data-index="0">
                    <section class="mb-4 mb-lg-5" id="countzSection" class="grid-stack-item">
                        <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Counts</h2>
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
                                    <div class="card h-100">
                                        <div class="card-body">
                                          <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                              <h4 class="fw-normal text-red">{{getClientsCount()}}</h4>
                                              <p class="subtitle text-sm text-muted mb-0">Clients</p>
                                            </div>
                                            <div class="flex-shrink-0 ms-3">
                                                <i class="fas fa-user-plus"></i>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="card-footer py-3 bg-red-light">
                                          <div class="row align-items-center text-red">
                                            <div class="col-10">
                                              <p class="mb-0">+{{getLastWeekClientsCount()}} from last week</p>
                                            </div>
                                            <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                            @endcanany
                            <div class="{{$class}}">
                                <div class="card h-100">
                                    <div class="card-body">
                                      <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                          <h4 class="fw-normal text-blue">{{getCandidatesCount()}}</h4>
                                          <p class="subtitle text-sm text-muted mb-0">Candidates</p>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card-footer py-3 bg-blue-light">
                                      <div class="row align-items-center text-blue">
                                        <div class="col-10">
                                          <p class="mb-0">+{{getLastWeekCandidatesCount()}} from last week</p>
                                        </div>
                                        <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="{{$class}}">
                                <div class="card h-100">
                                    <div class="card-body">
                                      <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                          <h4 class="fw-normal text-primary">{{getJobOpportunitiesCount()}}</h4>
                                          <p class="subtitle text-sm text-muted mb-0">Job Opportunities</p>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <i class="fas fas fa-plus-circle"></i>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card-footer py-3 bg-primary-light">
                                      <div class="row align-items-center text-primary">
                                        <div class="col-10">
                                          <p class="mb-0">+{{getLastWeekJobOpportunitiesCount()}} from last week</p>
                                        </div>
                                        <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="{{$class}}">
                                <div class="card h-100">
                                    <div class="card-body">
                                      <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                          <h4 class="fw-normal text-green">{{getSubmissionsCount()}}</h4>
                                          <p class="subtitle text-sm text-muted mb-0">Job Submissions</p>
                                        </div>
                                        <div class="flex-shrink-0 ms-3">
                                            <i class="fas fas fa-rss"></i>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="card-footer py-3 bg-green-light">
                                      <div class="row align-items-center text-green">
                                        <div class="col-10">
                                          <p class="mb-0">+{{getLastWeekSubmissionsCount()}} from last week</p>
                                        </div>
                                        <div class="col-2 text-end"><i class="fas fa-caret-up"></i>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div><p> </p>
                    </section><p> </p>
                </span>
                <span class="grid-stack-element" id="pipelineSection" draggable="true" data-index="1">
                    <section class="mb-4 mb-lg-5" id="pipelinezSection" class="grid-stack-item">
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
                    </section><p> </p>
                </div>
                <span class="grid-stack-element" id="interviewsSection" draggable="true" data-index="2">
                    <section class="mb-4 mb-lg-5" id="interviewzSection" class="grid-stack-item">
                        <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Upcoming Interviews</h2>
                        <div class="card">
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
                    </section><p> </p>
                </span>
                <span class="grid-stack-element" id="completedInterviewsSection" draggable="true" data-index="3">
                    <section class="mb-4 mb-lg-5" id="completedInterviewzSection" class="grid-stack-item">
                        <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Completed Interviews</h2>
                        <div class="card">
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
                    </section><p> </p>
                </span>
                <span class="grid-stack-element" id="recentSubmissionsSection" draggable="true" data-index="4">
                    <section class="mb-4 mb-lg-5" id="recentSubmissionzSection" class="grid-stack-item">
                        <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Recent Submissions</h2>
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                    </tr>
                                    @foreach (getRecentSubmissions() as $item)
                                        <tr>
                                            <td>{{$item->jobOpportunity?->title}}</td>
                                            <td>{{$item->contact}}</td>
                                            <td>{{$item->email_id}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </section><p> </p>
                </div>
                <span class="grid-stack-element" id="activityLogsSection" draggable="true" data-index="5">
                    <section class="mb-4 mb-lg-5" id="activityLogzSection" class="grid-stack-item">
                        <h2 class="section-heading section-heading-ms mb-4 mb-lg-5">Activity Logs</h2>
                        <div class="card">
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
                                                @elseif($item->subject_type == 'App\Models\Note')
                                                    a Note @ {{$item->created_at->diffForHumans()}}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </section><p> </p>
                </span>
            </div>
        </div>
    </div>
@endsection
@section('javascripts')
    <!-- Init Charts on Charts page-->
    <script src="{{asset('assets/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('assets/js/charts-defaults.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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

        $('#countsToggle').click(function(){
            if($(this).is(':checked')){
                $('#countsSection').show();
            }else{
                $('#countsSection').hide();
            }
        });

        $('#pipelineToggle').click(function(){
            if($(this).is(':checked')){
                $('#pipelineSection').show();
            }else{
                $('#pipelineSection').hide();
            }
        });

        $('#interviewsToggle').click(function(){
            if($(this).is(':checked')){
                $('#interviewsSection').show();
            }else{
                $('#interviewsSection').hide();
            }
        });

        $('#completedInterviewsToggle').click(function(){
            if($(this).is(':checked')){
                $('#completedInterviewsSection').show();
            }else{
                $('#completedInterviewsSection').hide();
            }
        });

        $('#submissionsToggle').click(function(){
            if($(this).is(':checked')){
                $('#recentSubmissionsSection').show();
            }else{
                $('#recentSubmissionsSection').hide();
            }
        });

        $('#activityLogsToggle').click(function(){
            if($(this).is(':checked')){
                $('#activityLogsSection').show();
            }else{
                $('#activityLogsSection').hide();
            }
        });

        
    </script>
    <script>
        let draggedWidget = null;
        let widgetOrder = []; // Array to store the order of widgets

        // Function to get the widget order from localStorage
        function getWidgetOrder() {
            return JSON.parse(localStorage.getItem('widgetOrder')) || [];
        }

        // Function to save the widget order to localStorage
        function saveWidgetOrder(order) {
            console.warn(JSON.stringify(order),'JSON.stringify(order)');
            localStorage.setItem('widgetOrder', JSON.stringify(order));
        }

        // Function to update the widget order array
        function updateWidgetOrder() {
            const widgets = document.querySelectorAll('.grid-stack-element');
            const order = Array.from(widgets).map((widget, index) => {
                widget.setAttribute('data-index', index);
                return index;
            });
            // Save the updated widget order to localStorage
            saveWidgetOrder(order);
        }

        document.addEventListener('dragstart', (event) => {
            draggedWidget = event.target;
        });

        document.addEventListener('dragover', (event) => {
            event.preventDefault();
        });

        document.addEventListener('drop', (event) => {
            event.preventDefault();
            // Find the closest parent with class "grid-stack-element"
            const targetElement = event.target.closest('.grid-stack-element');
            const draggedIndex = parseInt(draggedWidget.getAttribute('data-index'));
            const targetIndex = parseInt(targetElement.getAttribute('data-index'));
            if (!isNaN(draggedIndex) && !isNaN(targetIndex)) {
                // Update the data-index attribute
                draggedWidget.setAttribute('data-index', targetIndex);
                targetElement.setAttribute('data-index', draggedIndex);
            }
            if (draggedWidget !== null && targetElement) {
                // Swap the positions of the dragged and dropped widgets
                const tempHTML = draggedWidget.innerHTML;
                draggedWidget.innerHTML = targetElement.innerHTML;
                targetElement.innerHTML = tempHTML;
                // Update the widget order array
                updateWidgetOrder();
            }
            draggedWidget = null;
            drawChart();
        });
    </script>
@endsection