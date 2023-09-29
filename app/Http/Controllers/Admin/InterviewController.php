<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\Client;
use App\Models\User;
use App\Models\JobOpportunity;
use App\Models\AdditionalAttachment;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateInterview;
use App\Models\Candidate;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use DataTables;

class InterviewController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Interview::query();
            $search = $request->search;
            $candidate = $request->candidate;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('interview_name', 'like', '%' . $search . '%');
                });
            }
            if ($candidate) {
                $data->whereHas("candidate",function ($query) use ($candidate) {
                    $query->where('candidate_name', 'like', '%' . $candidate . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('client', function($data) {
                    if($data->client_id){
                        return $data?->client?->client_name??Null;
                    }else{
                        return Null;
                    }
                })
                ->addColumn('candidate', function($data) {
                    if($data->candidate_id){
                        return $data?->candidate?->candidate_name??Null;
                    }else{
                        return Null;
                    }
                })
                ->addColumn('interview_owner', function($data) {
                    if($data->interview_owner_id){
                        return $data?->interviewOwners?->first_name . ' ' . $data?->interviewOwners?->last_name;
                    }else{
                        return Null;
                    }
                })
                ->addColumn('action', 'backend.interviews.action')
                ->make(true);
        }
        return view('backend.interviews.index');
    }

    public function create()
    {
        $clients=Client::get();
        $users=User::whereNot('role', 'super_admin')->get();
        // $opportunities=JobOpportunity::get();
        return view('backend.interviews.create',['clients'=>$clients,'users'=>$users]);
    }

    public function store(ValidateInterview $request)
    {
        $res=Interview::create($request->except(['_token','attachments']));
        if($request->file('attachments')){
            $this->uploadAttachments($res->id,$request->file('attachments'));
        }
        if($res){
            return redirect()->route('admin.interviews.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.interviews.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show($id)
    {
        $id=Crypt::decrypt($id);
        $data=Interview::with(['client','interviewOwners','candidate','jobOpportunity','additionalAttachments'])->findOrFail($id);
        if($data){
            return response()->json(['success'=>true,'data'=>$data]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $data=Interview::findOrFail($id);
        $clients=Client::get();
        $users=User::whereNot('role', 'super_admin')->get();
        $opportunities=JobOpportunity::get();
        $candidate=Candidate::find($data->candidate_id);
        return view('backend.interviews.edit',['data'=>$data,'clients'=>$clients,'users'=>$users,'opportunities'=>$opportunities,'candidate'=>$candidate]);
    }

    public function update(ValidateInterview $request, $id)
    {
        $id=Crypt::decrypt($id);
        $data=Interview::findOrFail($id);
        $res=$data->update($request->except(['_token','attachments']));
        if($request->file('attachments')){
            $this->uploadAttachments($id,$request->file('attachments'));
        }
        if($res){
            return redirect()->route('admin.interviews.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.interviews.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $data=Interview::findOrFail($id);
        $res=$data->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    private function uploadAttachments($id, $attachments)
    {
        $atts=AdditionalAttachment::where('reference_id',$id)->where('reference_type','interview')->get();
        if(count($atts)>0){
            $atts->each->delete();
        }
        $allowedfileExtension=['pdf','jpg','png','docx','PNG'];
        $data=[];
        foreach($attachments as $file){
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $check=in_array($extension,$allowedfileExtension);
            //dd($check);
            if($check)
            {
                $filename= date('YmdHi'). mt_rand(10,100) .$file->getClientOriginalName();
                $file-> move(public_path('uploads/attachments'), $filename);
                $data[]=['reference_id'=>$id,'reference_type'=>'interview','attachment'=>$filename,'created_at'=>Now()];
            }
        }
        if(count($data)>0){
            AdditionalAttachment::insert($data);
        }
    }

    public function calendar()
    {
        $clients=Client::get();
        $users=User::whereNot('role', 'super_admin')->get();
        $events=Interview::get();
        $data=[];
        foreach($events as $event){
            $data[]=[
                'id'=>Crypt::encrypt($event->id),
                'title'=>$event->interview_name,
                'start'=>$event->from_date,
                'end'=>$event->to_date,
            ];
        }
        return view('backend.interviews.calendar.index',['clients'=>$clients,'users'=>$users,'events'=>$data]);
    }

}
