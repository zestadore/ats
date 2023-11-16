<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\PricingPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ValidateCompany;
use DataTables;

class CompanyController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Company::query();
            $search = $request->search;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('company_name', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'saas.companies.action')
                ->addColumn('plan', function ($data) {
                    return $data?->pricingPlan?->plan_name??Null;
                })
                ->addColumn('users', function ($data) {
                    return $data?->pricingPlan?->maximum_users??Null;
                })
                ->addColumn('invoices', function ($data) {
                    return $data?->pricingPlan?->monthly_invoices??Null;
                })
                ->make(true);
        }
        return view('saas.companies.index');
    }

    public function create()
    {
        $pricingPlans=PricingPlan::get();
        return view('saas.companies.create',['pricingPlans'=>$pricingPlans]);
    }

    public function store(ValidateCompany $request)
    {
        if($request->file('logo')){
            $request->validate([
                'logo' => 'required|file|max:2048|mimes:jpg,jpeg,png,gif',
            ]);
        }
        $res=Company::create($request->except(['_token','first_name','email','mobile','password_string','last_name','logo']))->id;
        if($request->file('logo')){
            $file= $request->file('logo');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/logos'), $filename);
            $logo= $filename;
            if($res){
                Company::where('id',$res)->update(['logo'=>$logo]);
            }
        }
        if($res){
            $compId=$res;
            $res=Null;
            $data=[
                'company_id'=>$compId,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
                'password'=>Hash::make($request->password_string??$request->mobile),
                'role'=>'company_admin'
            ];
            $res=$this->createUser($data);
        }
        if($request->ajax()){
            if($res){
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }else{
            if($res){
                return redirect()->route('admin.companies.index')->with('success', 'Successfully updated the data.');
            }else{
                return redirect()->route('admin.companies.index')->with('error', 'Failed to update the data. Please try again.');
            }
        }
    }

    public function show($id)
    {
        $res=Company::with(['pricingPlan','companyAdmin'])->find(Crypt::decrypt($id));
        if($res){
            return response()->json(['success'=>true,'data'=>$res]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $company=Company::findOrFail($id);
        $user=User::where('company_id',$id)->where('role','company_admin')->first();
        $pricingPlans=PricingPlan::get();
        return view('saas.companies.edit',['data'=>$company,'user'=>$user,'pricingPlans'=>$pricingPlans]);
    }

    public function update(ValidateCompany $request, $id)
    {
        dd($id);
        if($request->file('logo')){
            $request->validate([
                'logo' => 'required|file|max:2048|mimes:jpg,jpeg,png,gif',
            ]);
        }
        $id=Crypt::decrypt($id);
        $company=Company::findOrFail($id);
        $res=$company->update($request->except(['_token','first_name','email','mobile','password_string','last_name','logo']));
        if($request->file('logo')){
            if($company->logo!=null){
                $d=unlink(public_path('uploads/logos/'. $company->logo));
            }
            $file= $request->file('logo');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/logos'), $filename);
            $logo= $filename;
            if($res){
                $company->update(['logo'=>$logo]);
            }
        }
        if($res){
            $res=Null;
            if($request->password_string){
                $data=[
                    'company_id'=>$id,
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'email'=>$request->email,
                    'mobile'=>$request->mobile,
                    'password'=>Hash::make($request->password_string),
                    'role'=>'company_admin'
                ];
            }else{
                $data=[
                    'company_id'=>$id,
                    'first_name'=>$request->first_name,
                    'last_name'=>$request->last_name,
                    'email'=>$request->email,
                    'mobile'=>$request->mobile,
                    'role'=>'company_admin'
                ];
            }
            $res=$this->updateUser($data,$id);
        }
        if($request->ajax()){
            if($res){
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false]);
            }
        }else{
            if($res){
                return redirect()->route('admin.companies.index')->with('success', 'Successfully updated the data.');
            }else{
                return redirect()->route('admin.companies.index')->with('error', 'Failed to update the data. Please try again.');
            }
        }
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $company=Company::findOrFail($id);
        $res=$company->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    private function createUser($data)
    {
        $res=User::create($data);
        return $res;
    }

    private function updateUser($data,$companyId)
    {
        $res=User::where('company_id',$companyId)->where('role','company_admin')->update($data);
        return $res;
    }
}
