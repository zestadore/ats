<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardWidgetOrder extends Model
{
    use HasFactory;
    protected $table = 'dashboard_widget_orders';
    protected $guarded=[];

    protected $casts = [
        'order' => 'array',
    ];
}
