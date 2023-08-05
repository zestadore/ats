<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Models\JobOpportunity;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateSubmission;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class SubmissionController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Submission::query();
            $search = $request->search;
            $candidate = $request->candidate;
            if ($search) {
                $data->whereHas("jobOpportunity",function ($query) use ($search) {
                    $query->where('title', 'like', '%' . $search . '%');
                });
            }
            if ($candidate) {
                $data->whereHas("candidate",function ($query) use ($candidate) {
                    $query->where('candidate_name', 'like', '%' . $candidate . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('candidate', function($data) {
                    if($data->candidate_id){
                        return $data->candidate->candidate_name;
                    }else{
                        return Null;
                    }
                })
                ->addColumn('job_opportunity', function($data) {
                    if($data->job_title_id){
                        return $data->jobOpportunity->title;
                    }else{
                        return Null;
                    }
                })
                ->addColumn('action', 'backend.job_submissions.action')
                ->make(true);
        }
        return view('backend.job_submissions.index');
    }

    public function create()
    {
        $opportunities=JobOpportunity::get();
        $candidates=Candidate::take(100)->get();
        return view('backend.job_submissions.create',['opportunities'=>$opportunities,'candidates'=>$candidates]);
    }

    public function store(ValidateSubmission $request)
    {
        if($request->file('resume')){
            $request->validate([
                'resume' => 'required|file|max:2048|mimes:docx,doc,pdf',
            ]);
        }
        $res=Submission::create($request->except(['_token','resume']))->id;
        if($request->file('resume')){
            $file= $request->file('resume');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/resumes'), $filename);
            $resume= $filename;
            if($res){
                Submission::where('id',$res)->update(['resume'=>$resume]);
            }
        }
        if($res){
            return redirect()->route('admin.job-submissions.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.job-submissions.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show($id)
    {
        $res=Submission::with(['jobOpportunity','candidate'])->find(Crypt::decrypt($id));
        if($res){
            return response()->json(['success'=>true,'data'=>$res]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $data=Submission::findOrFail($id);
        $opportunities=JobOpportunity::get();
        $candidates=Candidate::where('id',$data->candidate_id)->first();
        return view('backend.job_submissions.edit',['data'=>$data,'opportunities'=>$opportunities,'candidates'=>$candidates]);
    }

    public function update(ValidateSubmission $request, $id)
    {
        if($request->file('resume')){
            $request->validate([
                'resume' => 'required|file|max:2048|mimes:docx,doc,pdf',
            ]);
        }
        $id=Crypt::decrypt($id);
        $data=Submission::findOrFail($id);
        $res=$data->update($request->except(['_token','resume']));
        if($request->file('resume')){
            if($data->resume!=null){
                $d=unlink(public_path('uploads/resumes/'. $data->resume));
            }
            $file= $request->file('resume');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/resumes'), $filename);
            $resume= $filename;
            if($res){
                $data->update(['resume'=>$resume]);
            }
        }
        if($res){
            return redirect()->route('admin.job-submissions.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.job-submissions.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $data=Submission::findOrFail($id);
        $res=$data->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }
}
