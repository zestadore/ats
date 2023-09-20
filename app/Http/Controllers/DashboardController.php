<?php

namespace App\Http\Controllers;
use App\Models\DashboardWidgetOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function saveDashboardOrder(Request $request)
    {
        $order=DashboardWidgetOrder::where('user_id',Auth::user()->id)->first();
        if($order){
            $res=$order->update($request->except('_token'));
        }else{
            $res=DashboardWidgetOrder::create($request->except('_token'));
        }
        if($res){
            return response()->json([
                'success'=>true
            ]);
        }else{
            return response()->json([
                'success'=>false
            ]);
        }
    }
}
