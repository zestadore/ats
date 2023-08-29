<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\JobSubmissionMail;
use Illuminate\Support\Facades\Mail;
use App\Models\JobOpportunity;
use App\Models\User;

class JobSubmissionMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $submission;

    public function __construct($submission)
    {
        $this->submission = $submission;
    }

    public function handle(): void
    {
        $emailId=$this->submission->email_id;
        $email = new JobSubmissionMail();
        Mail::to($emailId)->send($email);
        $jobOpportunity=JobOpportunity::find($this->submission->job_title_id);
        $accountManagerIds=$jobOpportunity->job_owner??[];
        foreach($accountManagerIds as $id){
            $accountManager=User::find($id);
            // info($accountManager->email);
            $email = new JobSubmissionMail();
            Mail::to($accountManager->email)->send($email);
        }
        $admins=User::where('role','super_admin')->get();
        foreach($admins as $admin){
            $email = new JobSubmissionMail();
            Mail::to($admin->email)->send($email);
        }
    }
}
