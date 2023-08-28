<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Jobs\JobSubmissionMailJob;
use App\Models\Scopes\SaasScope;

class Submission extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table = 'submissions';
    protected $guarded=[];
    protected $appends=['resume_path'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->company_id=Auth::user()->company_id;
            $model->created_by = Auth::user()->id;
        });
        static::created(function (Submission $submission) {
            dispatch(new JobSubmissionMailJob($submission));
        });
        static::updating(function($model)
        {
            $model->updated_by = Auth::user()->id;
        });
        static::deleting(function($model)
        {
            if($model->resume!=null){
                $d=unlink(public_path('uploads/resumes/'. $model->resume));
            }
            $model->resume = Null;
            $model->deleted_by = Auth::user()->id;
            $model->save();
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new SaasScope);
    }

    public function candidate(){
        return $this->hasOne(Candidate::class, 'id', 'candidate_id');
    }

    public function jobOpportunity(){
        return $this->hasOne(JobOpportunity::class, 'id', 'job_title_id');
    }

    public function getResumePathAttribute(){
        if($this->attributes['resume']!=null){
            return url('/') .'/uploads/resumes/'.$this->attributes['resume'];
        }else{
            return null;
        }
    }

    public function additionalAttachments(){
        return $this->hasMany(AdditionalAttachment::class, 'reference_id', 'id')->where('reference_type', 'submission');
    }

}
