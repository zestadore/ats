<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\SaasScope;

class Interview extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table = 'interviews';
    protected $guarded=[];
    protected $appends=['interviewers_names'];

    protected $casts = [
        'interviewers_id' => 'array',
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

    public function candidate(){
        return $this->hasOne(Candidate::class, 'id', 'candidate_id');
    }

    public function jobOpportunity(){
        return $this->hasOne(JobOpportunity::class, 'id', 'job_opportunity_id');
    }

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function interviewOwners(){
        return $this->hasOne(User::class, 'id', 'interview_owner_id');
    }

    public function additionalAttachments(){
        return $this->hasMany(AdditionalAttachment::class, 'reference_id', 'id')->where('reference_type', 'interview');
    }

    public function getInterviewersNamesAttribute(){
        $ids=json_decode($this->attributes['interviewers_id']);
        $names=[];
        if(is_array($ids)){
            foreach($ids as $id){
                $client=Client::find((int)$id);
                if($client){
                    $names[]=$client->client_name;
                }else{
                    $names[]=Null;
                }
            }
        }else{
            $client=Client::find((int)$ids);
            if($client){
                $names[]=$client->client_name;
            }else{
                $names[]=Null;
            }
        }
        return implode(", ",$names);
    }
}
