<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PricingPlan extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table = 'pricing_plans';
    protected $guarded=[];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    protected $casts = [
        'permissions' => 'array',
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
}
