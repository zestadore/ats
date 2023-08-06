<?php
  
use App\Models\Client;
use App\Models\Candidate;
use App\Models\JobOpportunity;
use App\Models\Submission;
use App\Models\Interview;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

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

    function getUpComingInterviews(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('from_date','>=', Carbon::now())->latest()->take(10)->get();
        }else{
            return Interview::where('from_date','>=', Carbon::now())->where('created_by',Auth::user()->id)->latest()->take(10)->get();
        }
    }

    function getCompletedInterviews(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('to_date','<', Carbon::now())->latest()->take(10)->get();
        }else{
            return Interview::where('to_date','<', Carbon::now())->where('created_by',Auth::user()->id)->latest()->take(10)->get();
        }
    }

    function getUserActivityLogs(){
        return Activity::causedBy(Auth::user())->latest()->take(10)->get();
    }

    function getInternalInterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','Internal_interview')->count();
    }

    function getGeneralInterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','general_interview')->count();
    }

    function getOnlineInterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','online_interview')->count();
    }

    function getPhoneInterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','phone_interview')->count();
    }

    function getLevel1InterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','level1_interview')->count();
    }

    function getLevel2InterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','level2_interview')->count();
    }

    function getLevel3InterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','level3_interview')->count();
    }

    function getLevel4InterviewCounts(){
        return Interview::where('created_by',Auth::user()->id)->where('interview_name','level4_interview')->count();
    }

?>