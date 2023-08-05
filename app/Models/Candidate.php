<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Candidate extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'candidates';
    protected $guarded=[];
    protected $appends=['resume_path'];

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

    public function getResumePathAttribute(){
        if($this->attributes['resume']!=null){
            return url('/') .'/uploads/resumes/'.$this->attributes['resume'];
        }else{
            return null;
        }
    }
}
