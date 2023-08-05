<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class Interview extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'interviews';
    protected $guarded=[];
    protected $appends=['interviewers_names'];

    protected $casts = [
        'interviewers_id' => 'array',
    ];

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
            $model->deleted_by = Auth::user()->id;
            $model->save();
        });
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

    public function getInterviewersNamesAttribute(){
        $ids=json_decode($this->attributes['interviewers_id']);
        $names=[];
        foreach($ids as $id){
            $client=Client::find((int)$id);
            $names[]=$client->client_name;
        }
        return implode(", ",$names);
    }
}
