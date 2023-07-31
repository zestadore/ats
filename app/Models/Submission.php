<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Submission extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'submissions';
    protected $guarded=[];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $model->created_by = Auth::user()->id;
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

    public function candidate(){
        return $this->hasOne(Candidate::class, 'id', 'candidate_id');
    }

    public function jobOpportunity(){
        return $this->hasOne(JobOpportunity::class, 'id', 'job_title_id');
    }

}
