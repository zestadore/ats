<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\Scopes\SaasScope;

class Invoice extends Model
{
    use HasFactory,SoftDeletes,LogsActivity;
    protected $table = 'invoices';
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

    public function client(){
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function invoiceDetails(){
        return $this->hasMany(InvoiceDetails::class, 'invoice_id', 'id');
    }
}
