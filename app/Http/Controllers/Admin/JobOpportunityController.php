<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\EndClient;
use App\Models\JobOpportunity;
use App\Models\User;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateJobOpportunity;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class JobOpportunityController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= JobOpportunity::query();
            $search = $request->search;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'backend.job_opportunities.action')
                ->addColumn('client', function($data) {
                    if($data->client_id){
                        return $data?->client?->client_name??Null;
                    }else{
                        return Null;
                    }
                })
                ->addColumn('matches', function ($data) {
                    if($data->candidates){
                        $count=count($data->candidates);
                        return "<a style='cursor: pointer;' href='".route('admin.get-opportunity-matches',Crypt::encrypt($data->id))."'><label class='badge badge-primary-light'>".$count." Matches Found</label></a>";
                    }else{
                        return "<label class='badge badge-primary-light'>0 Matches Found</label>";
                    }
                })
                ->addColumn('end_client', function($data) {
                    if($data->end_client_id){
                        return $data?->endClient?->end_client??Null;
                    }else{
                        return Null;
                    }
                })
                ->escapeColumns('aaData')
                ->make(true);
        }
        return view('backend.job_opportunities.index');
    }

    public function create()
    {
        $clients=Client::get();
        $accountManagers=User::where('role','account_manager')->get();
        $recruiters=User::where('role','recruiter')->get();
        return view('backend.job_opportunities.create',['clients'=>$clients,'accountManagers'=>$accountManagers,'recruiters'=>$recruiters]);
    }

    public function store(ValidateJobOpportunity $request)
    {
        $res=JobOpportunity::create($request->except(['_token','files']))->id;
        if(!$request->status){
            $res=JobOpportunity::where('id',$res)->update(['status'=>0]);
        }
        if($res){
            return redirect()->route('admin.job-opportunities.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.job-opportunities.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show($id)
    {
        $res=JobOpportunity::with(['client','endClient'])->find(Crypt::decrypt($id));
        if($res){
            return response()->json(['success'=>true,'data'=>$res]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $data=JobOpportunity::findOrFail($id);
        $clients=Client::get();
        $endClients=EndClient::where('client_id',$data->client_id)->get();
        $accountManagers=User::where('role','account_manager')->get();
        $recruiters=User::where('role','recruiter')->get();
        return view('backend.job_opportunities.edit',['data'=>$data,'clients'=>$clients,'endClients'=>$endClients,'accountManagers'=>$accountManagers,'recruiters'=>$recruiters]);
    }

    public function update(Request $request, $id)
    {
        $id=Crypt::decrypt($id);
        $data=JobOpportunity::findOrFail($id);
        $res=$data->update($request->except(['_token','files']));
        if(!$request->status){
            $res=$data->update(['status'=>0]);
        }
        if($res){
            return redirect()->route('admin.job-opportunities.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->back()->route('admin.job-opportunities.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $data=JobOpportunity::findOrFail($id);
        $res=$data->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    public function getClientJobOpportunity($clientId)
    {
        $data=JobOpportunity::where('client_id',$clientId)->get();
        return response()->json($data);
    }

    public function getMatches($id)
    {
        $opportunity=JobOpportunity::find(Crypt::decrypt($id));
        $matches=$opportunity->candidates()->paginate(25);
        return view('backend.job_opportunities.matches',['opportunity'=>$opportunity,'matches'=>$matches]);
    }

}
