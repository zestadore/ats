<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use App\Http\Requests\ValidatePricingPlan;
use DataTables;
use Illuminate\Support\Facades\Crypt;

class PricingPlanController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= PricingPlan::query();
            $search = $request->search;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('plan_name', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'saas.pricing_plans.action')
                ->make(true);
        }
        return view('saas.pricing_plans.index');
    }

    public function create()
    {
        return view('saas.pricing_plans.create');
    }

    public function store(ValidatePricingPlan $request)
    {
        $res=PricingPlan::create($request->except(['_token']))->id;
        if($request->ajax()){
            if($res){
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }else{
            if($res){
                return redirect()->route('admin.pricing-plans.index')->with('success', 'Successfully updated the data.');
            }else{
                return redirect()->route('admin.pricing-plans.index')->with('error', 'Failed to update the data. Please try again.');
            }
        }
    }

    public function show($id)
    {
        $res=PricingPlan::find(Crypt::decrypt($id));
        if($res){
            return response()->json(['success'=>true,'data'=>$res]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $data=PricingPlan::findOrFail($id);
        return view('saas.pricing_plans.edit',['data'=>$data]);
    }

    public function update(ValidatePricingPlan $request, $id)
    {
        $id=Crypt::decrypt($id);
        $data=PricingPlan::findOrFail($id);
        $res=$data->update($request->except(['_token']));
        if($request->ajax()){
            if($res){
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }else{
            if($res){
                return redirect()->route('admin.pricing-plans.index')->with('success', 'Successfully updated the data.');
            }else{
                return redirect()->route('admin.pricing-plans.index')->with('error', 'Failed to update the data. Please try again.');
            }
        }
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $data=PricingPlan::findOrFail($id);
        $res=$data->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }
}
