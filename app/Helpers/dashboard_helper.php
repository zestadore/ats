<?php
  
use App\Models\Client;
use App\Models\Candidate;
use App\Models\JobOpportunity;
use App\Models\Submission;
use Carbon\Carbon;

    function getClientsCount(){
        return Client::count();
    }

    function getCandidatesCount(){
        return Candidate::count();
    }

    function getJobOpportunitiesCount(){
        return JobOpportunity::count();
    }

    function getSubmissionsCount(){
        return Submission::count();
    }

    function getLastWeekClientsCount(){
        return Client::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
    }

    function getLastWeekCandidatesCount(){
        return Candidate::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
    }

    function getLastWeekJobOpportunitiesCount(){
        return JobOpportunity::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
    }

    function getLastWeekSubmissionsCount(){
        return Submission::whereBetween('created_at', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()])->count();
    }

    function getLatestClients(){
        return Client::latest()->take(10)->get();
    }

    function getLatestCandidates(){
        return Candidate::latest()->take(10)->get();
    }

    function getLatestJobOpportunities(){
        return JobOpportunity::latest()->take(10)->get();
    }

    function getLatestSubmissions(){
        return Submission::latest()->take(10)->get();
    }

?>