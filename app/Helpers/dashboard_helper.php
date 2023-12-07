<?php
  
use App\Models\Client;
use App\Models\Candidate;
use App\Models\JobOpportunity;
use App\Models\Submission;
use App\Models\Interview;
use App\Models\User;
use App\Models\DashboardWidgetOrder;
use App\Classes\HelperClass;
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

    function getRecentSubmissions(){
        if(Auth::user()->role=="super_admin"){
            return Submission::latest()->take(10)->get();
        }else{
            return Submission::latest()->where('created_by',Auth::user()->id)->latest()->take(10)->get();
        }
    }

    function getUserActivityLogs(){
        if(Auth::user()->role=="super_admin"){
            return Activity::latest()->take(10)->get();
        }else{
            return Activity::causedBy(Auth::user())->latest()->take(10)->get();
        }
        
    }

    function getInternalInterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','Internal_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','internal_interview')->count();
        }
        
    }

    function getGeneralInterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','general_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','general_interview')->count();
        }
    }

    function getOnlineInterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','online_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','online_interview')->count();
        }
    }

    function getPhoneInterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','phone_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','phone_interview')->count();
        }
    }

    function getLevel1InterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','level1_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','level1_interview')->count();
        }
    }

    function getLevel2InterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','level2_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','level2_interview')->count();
        }
    }

    function getLevel3InterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','level3_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','level3_interview')->count();
        }
    }

    function getLevel4InterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::where('interview_name','level4_interview')->count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->where('interview_name','level4_interview')->count();
        }
    }

    function getTotalInterviewCounts(){
        if(Auth::user()->role=="super_admin"){
            return Interview::count();
        }else{
            return Interview::where('created_by',Auth::user()->id)->count();
        }
    }

    function getUserName($id){
        $user = User::find($id);
        return $user?->full_name;
    }

    function getDashboardWidgetOrder(){
        $order= DashboardWidgetOrder::where('user_id',Auth::user()->id)->first();
        if($order){
            return $order->order;
        }else{
            $res=DashboardWidgetOrder::create(['user_id'=>Auth::user()->id,'order'=>[
                "countzSection",
                "pipelinezSection",
                "interviewzSection",
                "completedInterviewzSection",
                "recentSubmissionzSection",
                "activityLogzSection"
            ]]);
            return $res->order;
        }
    }
    
    function getRelatedUsers(){
        
        $role=Auth::user()->role;
        if($role=='super_admin'){
            $users=User::where('id','!=',Auth::user()->id)->get();
            return $users;
        }else{
            $helperClass=New HelperClass;
            $rolesList=$helperClass->getRolesList();
            $roles=[];
            foreach($rolesList as $rolez){
                $roles[]=$rolez['id'];
            }
            $users=User::where('id','!=',Auth::user()->id)->whereIn('role',$roles)->get();
            return $users;
        }
    }

    function getPageTitle($route,$mode){
        switch($route){
            case 'admin.pricing-plans.index':
                return $mode . ' Pricing Plan';
            case 'admin.clients.index':
                return $mode . ' Client';
            case 'admin.clients.end-clients.index':
                return $mode . ' End Client';
            case 'admin.candidates.index':
                return $mode . ' Candidate';
            case 'admin.job-opportunities.index':
                return $mode . ' Job Opportunity';
            case 'admin.job-submissions.index':
                return $mode . ' Job Submission';
            case 'admin.users.index':
                return $mode . ' User';
            case 'admin.interviews.index':
                return $mode . ' Interview';
            case 'admin.companies.index':
                return $mode . ' Company';
            case 'admin.invoices.index':
                return $mode . ' Invoice';
            case 'admin.view.calendar':
                return $mode . ' Interview';
            default:
                return $mode . ' ' . $route;
        }
    }

?>