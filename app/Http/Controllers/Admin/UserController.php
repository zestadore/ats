<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Classes\HelperClass;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ValidateUser;
use Illuminate\Support\Facades\Auth;
use DataTables;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->role=="super_admin"){
                $data= User::query();
            }elseif(Auth::user()->role=="account_manager"){
                $data= User::query()->where('role','recruiter')->where('created_by',Auth::user()->id);
            }elseif(Auth::user()->role=="team_lead"){
                $data= User::query()->whereIn('role',['recruiter','account_manager'])->where('created_by',Auth::user()->id);
            }
            $search = $request->search;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'backend.users.action')
                ->make(true);
        }
        return view('backend.users.index');
    }

    public function create()
    {
        $helperClass=New HelperClass;
        $roles=$helperClass->getRolesList();
        return view('backend.users.create',['roles'=>$roles]);
    }

    public function store(ValidateUser $request)
    {
        $request->merge(['password', Hash::make($request->mobile)]);
        $request->request->add(['password'=> Hash::make($request->mobile)]);
        $res=User::create($request->except('_token'));
        if($res){
            return redirect()->route('admin.users.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.users.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show($id)
    {
        $res=User::find(Crypt::decrypt($id));
        if($res){
            return response()->json(['success'=>true,'data'=>$res]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $data=User::findOrFail($id);
        $helperClass=New HelperClass;
        $roles=$helperClass->getRolesList();
        return view('backend.users.edit',['data'=>$data,'roles'=>$roles]);
    }

    public function update(ValidateUser $request, $id)
    {
        $id=Crypt::decrypt($id);
        $data=User::findOrFail($id);
        $res=$data->update($request->except('_token'));
        if($res){
            return redirect()->route('admin.users.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.users.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $data=User::findOrFail($id);
        $res=$data->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }
}
