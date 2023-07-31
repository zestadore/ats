<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobOpportunity extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'job_opportunities';
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
            $model->deleted_by = Auth::user()->id;
            $model->save();
        });
    }

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function endClient(){
        return $this->hasOne(EndClient::class, 'id', 'end_client_id');
    }
    
}
