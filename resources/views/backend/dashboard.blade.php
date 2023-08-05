@extends('layouts.app')
@section('title')
    ATS - Dashboard
@endsection
@section('contents')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Dashboard</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
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
            @canany(['isAdmin','isAccountManager','isTeamLead'])
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
                @canany(['isAdmin','isAccountManager','isTeamLead'])
                    <div class="{{$class}}">
                        <div class="card radius-10 border-start border-0 border-4 border-info">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div>
                                        <p class="mb-0 text-secondary">Total Clients</p>
                                        <h4 class="my-1 text-info">{{getClientsCount()}}</h4>
                                        <p class="mb-0 font-13">+{{getLastWeekClientsCount()}} from last week</p>
                                    </div>
                                    <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class="bx bx-user-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcanany
                <div class="{{$class}}">
                    <div class="card radius-10 border-start border-0 border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Candidates</p>
                                    <h4 class="my-1 text-info">{{getCandidatesCount()}}</h4>
                                    <p class="mb-0 font-13">+{{getLastWeekCandidatesCount()}} from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class="bx bx-user-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="{{$class}}">
                    <div class="card radius-10 border-start border-0 border-4 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Job Opportunities</p>
                                    <h4 class="my-1 text-info">{{getJobOpportunitiesCount()}}</h4>
                                    <p class="mb-0 font-13">+{{getLastWeekJobOpportunitiesCount()}} from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class="bx bx-book-add"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="{{$class}}">
                    <div class="card radius-10 border-start border-0 border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Job Submissions</p>
                                    <h4 class="my-1 text-info">{{getSubmissionsCount()}}</h4>
                                    <p class="mb-0 font-13">+{{getLastWeekSubmissionsCount()}} from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i class="bx bx-comment-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
            </div>
        </div>
    </div>
@endsection