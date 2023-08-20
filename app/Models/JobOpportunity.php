<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\SaasScope;

class JobOpportunity extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table = 'job_opportunities';
    protected $guarded=[];
    protected $appends=['job_owner_names','assign_recruiter_names'];

    protected $casts = [
        'job_owner' => 'array','assign_recruiter' => 'array',
    ];

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
        static::updating(function($model)
        {
            $model->updated_by = Auth::user()->id;
        });
        static::deleting(function($model)
        {
            $model->deleted_by = Auth::user()->id;
            $model->save();
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new SaasScope);
    }

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function endClient(){
        return $this->hasOne(EndClient::class, 'id', 'end_client_id');
    }

    public function getJobOwnerNamesAttribute(){
        $ids=json_decode($this->attributes['job_owner']);
        $names=[];
        if(is_array($ids)){
            foreach($ids as $id){
                $user=User::find((int)$id);
                if($user){
                    $names[]=$user->full_name;
                }else{
                    $names[]=Null;
                }
            }
        }else{
            $user=User::find((int)$ids);
            if($user){
                $names[]=$user->full_name;
            }else{
                $names[]=Null;
            }
        }
        return implode(", ",$names);
    }

    public function getAssignRecruiterNamesAttribute(){
        $ids=json_decode($this->attributes['assign_recruiter']);
        $names=[];
        if(is_array($ids)){
            foreach($ids as $id){
                $user=User::find((int)$id);
                if($user){
                    $names[]=$user->full_name;
                }else{
                    $names[]=Null;
                }
            }
        }else{
            $user=User::find((int)$ids);
            if($user){
                $names[]=$user->full_name;
            }else{
                $names[]=Null;
            }
        }
        return implode(", ",$names);
    }
    
}
