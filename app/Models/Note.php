<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\SaasScope;

class Note extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'notes';
    protected $guarded=[];

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
        static::updating(function($model)
        {
            $model->updated_by = Auth::user()->id;
        });
    }

    protected static function booted()
    {
        static::addGlobalScope(new SaasScope);
    }

    public function assignedTo(){
        return $this->belongsTo(User::class, 'assigned_to', 'id');
    }
}
