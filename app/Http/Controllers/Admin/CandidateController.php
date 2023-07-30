<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateCandidate;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class CandidateController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Candidate::query();
            $search = $request->search;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('candidate_name', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'backend.candidates.action')
                ->make(true);
        }
        return view('backend.candidates.index');
    }

    public function create()
    {
        return view('backend.candidates.create');
    }

    public function store(ValidateCandidate $request)
    {
        if($request->file('resume')){
            $request->validate([
                'resume' => 'required|file|max:2048|mimes:docx,doc,pdf',
            ]);
        }
        $res=Candidate::create($request->except(['_token','resume']))->id;
        if($request->file('resume')){
            $file= $request->file('resume');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/resumes'), $filename);
            $resume= $filename;
            if($res){
                Candidate::where('id',$res)->update(['resume'=>$resume]);
            }
        }
        if($res){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show(Candidate $candidate)
    {
        //
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $candidate=Candidate::findOrFail($id);
        return view('backend.candidates.edit',['data'=>$candidate]);
    }

    public function update(ValidateCandidate $request, $id)
    {
        if($request->file('resume')){
            $request->validate([
                'resume' => 'required|file|max:2048|mimes:docx,doc,pdf',
            ]);
        }
        $id=Crypt::decrypt($id);
        $candidate=Candidate::findOrFail($id);
        $res=$candidate->update($request->except(['_token','resume']));
        if($request->file('resume')){
            if($candidate->resume!=null){
                $d=unlink(public_path('uploads/resumes/'. $candidate->resume));
            }
            $file= $request->file('resume');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/resumes'), $filename);
            $resume= $filename;
            if($res){
                $candidate->update(['resume'=>$resume]);
            }
        }
        if($res){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function destroy( $id)
    {
        $id=Crypt::decrypt($id);
        $candidate=Candidate::findOrFail($id);
        $res=$candidate->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }
}
