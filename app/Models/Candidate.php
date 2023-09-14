<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\SaasScope;

class Candidate extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table = 'candidates';
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
            $model->company_id=Auth::user()->company_id??1;
            $model->created_by = Auth::user()->id;
        });
        static::created(function($model)
        {
            //attaching pivots
            $skillArray=[];
            $keySkillArray=[];
            $keyWords=$model->skills;
            $skillArray=explode(",",$keyWords);
            $keyWords=$model->key_skills;
            $keySkillArray=explode(",",$keyWords);
            $skillArray=array_merge($skillArray,$keySkillArray);
            $idArray=[];
            foreach($skillArray as $skill){
                if($skill!=Null and $skill!="" and $skill!=" "){
                    $ids=JobOpportunity::where('key_skills', 'like', '%' . $skill . '%')->orWhere('notes', 'like', '%' . $skill . '%')
                    ->orWhere('description', 'like', '%' . $skill . '%')->orWhere('title', 'like', '%' . $skill . '%')->pluck('id')->toArray();
                    $idArray=array_merge($idArray,$ids);
                }
            }
            $idArray=array_unique($idArray);
            $model->opportunities()->attach($idArray);
            $skills=$model->skills;
            $skills=explode(",",$skills);
            $data=[];
            foreach($skills as $skill){
                $test=SkillSet::where('skill',$skill)->first();
                if(!$test){
                    $data[]=['skill'=>$skill,'title'=>$model->job_title];
                }
            }
            if(count($data)>0){
                SkillSet::insert($data);
            }
        });
        static::updating(function($model)
        {
            $model->updated_by = Auth::user()->id;
            //attaching pivots
            $skillArray=[];
            $keySkillArray=[];
            $keyWords=$model->skills;
            $skillArray=explode(",",$keyWords);
            $keyWords=$model->key_skills;
            $keySkillArray=explode(",",$keyWords);
            $skillArray=array_merge($skillArray,$keySkillArray);
            $idArray=[];
            foreach($skillArray as $skill){
                if($skill!=Null and $skill!="" and $skill!=" "){
                    $ids=JobOpportunity::where('key_skills', 'like', '%' . $skill . '%')->orWhere('notes', 'like', '%' . $skill . '%')
                    ->orWhere('description', 'like', '%' . $skill . '%')->orWhere('title', 'like', '%' . $skill . '%')->pluck('id')->toArray();
                    $idArray=array_merge($idArray,$ids);
                }
            }
            $idArray=array_unique($idArray);
            $model->opportunities()->sync($idArray);
            $skills=$model->skills;
            $skills=explode(",",$skills);
            $data=[];
            foreach($skills as $skill){
                $test=SkillSet::where('skill',$skill)->first();
                if(!$test){
                    $data[]=['skill'=>$skill,'title'=>$model->job_title];
                }
            }
            if(count($data)>0){
                SkillSet::insert($data);
            }
        });
        static::deleting(function($model)
        {
            if($model->resume!=null){
                $d=unlink(public_path('public/uploads/resumes/'. $model->resume));
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

    public function getResumePathAttribute(){
        if($this->resume!=null){
            return url('/') .'/uploads/resumes/'.$this->attributes['resume'];
        }else{
            return null;
        }
    }

    public function additionalAttachments(){
        return $this->hasMany(AdditionalAttachment::class, 'reference_id', 'id')->where('reference_type', 'candidate');
    }

    public function opportunities()
    {
        return $this->belongsToMany(JobOpportunity::class);
    }
}
