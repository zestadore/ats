<?php

namespace App\Models;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalAttachment extends Model
{
    use HasFactory,LogsActivity;
    protected $table = 'additional_attachments';
    protected $guarded=[];
    protected $appends=['attachment_path'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*']);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function($model)
        {
            if($model->attachment!=null){
                $d=unlink(public_path('uploads/attachments/'. $model->attachment));
            }
        });
    }

    public function getAttachmentPathAttribute(){
        if($this->attributes['attachment']!=null){
            return url('/') .'/uploads/attachments/'.$this->attributes['attachment'];
        }else{
            return null;
        }
    }

}
