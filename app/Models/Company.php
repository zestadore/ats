<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Company extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table = 'companies';
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
            // $model->created_by = Auth::user()->id;
        });
        static::updating(function($model)
        {
            // $model->updated_by = Auth::user()->id;
        });
        static::deleting(function($model)
        {
            if($model->logo!=null){
                $d=unlink(public_path('uploads/logos/'. $model->logo));
            }
            $model->logo = Null;
            $model->deleted_by = Auth::user()->id;
            $model->save();
        });
    }

    public function pricingPlan(){
        return $this->hasOne(PricingPlan::class, 'id', 'pricing_plan_id');
    }

    public function companyAdmin(){
        return $this->hasOne(User::class, 'company_id', 'id')->where('role','company_admin');
    }
}
