<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\JobOpportunity;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateCandidate;
use Illuminate\Support\Facades\Crypt;
use App\Models\AdditionalAttachment;
use App\Models\Submission;
use DataTables;

class CandidateController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Candidate::query();
            $search = $request->search;
            $location = $request->location;
            $title=$request->title;
            $contact=$request->contact;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('candidate_name', 'like', '%' . $search . '%');
                });
            }
            if ($location) {
                $data->where(function ($query) use ($location) {
                    $query->where('location', 'like', '%' . $location . '%');
                });
            }
            if ($title) {
                $data->where(function ($query) use ($title) {
                    $query->where('job_title', 'like', '%' . $title . '%');
                });
            }
            if ($contact) {
                $data->where(function ($query) use ($contact) {
                    $query->where('email', 'like', '%' . $contact . '%')->orWhere('contact', 'like', '%' . $contact . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'backend.candidates.action')
                ->addColumn('matches', function ($data) {
                    if($data->opportunities){
                        $count=count($data->opportunities);
                        return "<label class='badge badge-primary-light'>".$count." Matches Found</label>";
                    }else{
                        return "<label class='badge badge-primary-light'>0 Matches Found</label>";
                    }
                })
                ->escapeColumns('aaData')
                ->make(true);
        }
        return view('backend.candidates.index');
    }

    public function create()
    {
        $renderHtml=view('backend.candidates.add_more')->render();
        $renderHtml = preg_replace("/[\r\n]*/","",$renderHtml);
        return view('backend.candidates.create',['renderHtml'=>$renderHtml]);
    }

    public function store(ValidateCandidate $request)
    {
        if($request->file('resume')){
            $request->validate([
                'resume' => 'required|file|max:2048|mimes:docx,doc,pdf',
            ]);
        }
        $res=Candidate::create($request->except(['_token','resume','attachment_name','attachment']))->id;
        if($request->file('resume')){
            $file= $request->file('resume');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/resumes'), $filename);
            $resume= $filename;
            if($res){
                Candidate::where('id',$res)->update(['resume'=>$resume]);
            }
        }
        if ($res) {
            $x = count($request->attachment_name);
            $data = [];
            $allowedfileExtension = ['pdf', 'jpg', 'png', 'PNG'];
            for ($i = 0; $i < $x; $i++) {
                if ($request->attachment_name[$i] != null && $request->file('attachment')[$i]) {
                    $file = $request->file('attachment')[$i];
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $filename = date('YmdHi') . mt_rand(10, 100) . $file->getClientOriginalName();
                        $file->move(public_path('uploads/attachments'), $filename);
                        $data[] = [
                            'reference_id' => $res,
                            'reference_type' => 'candidate',
                            'attachment' => $filename,
                            'description' => $request->attachment_name[$i],
                            'created_at' => now(),
                        ];
                    }
                }
            }
            if (count($data) > 0) {
                $res = AdditionalAttachment::insert($data);
            }
        }
        if($res){
            if($request->ajax()){
                return response()->json(['success'=>"Data added successfully!"]);
            }
            return redirect()->route('admin.candidates.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.candidates.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show($id)
    {
        $res=Candidate::with(['additionalAttachments'])->find(Crypt::decrypt($id));
        if($res){
            return response()->json(['success'=>true,'data'=>$res]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $candidate=Candidate::with(['additionalAttachments'])->findOrFail($id);
        $renderHtml=view('backend.candidates.add_more')->render();
        $renderHtml = preg_replace("/[\r\n]*/","",$renderHtml);
        return view('backend.candidates.edit',['data'=>$candidate,'renderHtml'=>$renderHtml]);
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
        $res=$candidate->update($request->except(['_token','resume','attachment_name','attachment']));
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
        if ($res) {
            $x = count($request->attachment_name);
            $data = [];
            $allowedfileExtension = ['pdf', 'jpg', 'png', 'PNG'];
            for ($i = 0; $i < $x; $i++) {
                if ($request->attachment_name[$i] != null && $request->file('attachment')[$i]) {
                    $file = $request->file('attachment')[$i];
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $filename = date('YmdHi') . mt_rand(10, 100) . $file->getClientOriginalName();
                        $file->move(public_path('uploads/attachments'), $filename);
                        $data[] = [
                            'reference_id' => $id,
                            'reference_type' => 'candidate',
                            'attachment' => $filename,
                            'description' => $request->attachment_name[$i],
                            'created_at' => now(),
                        ];
                    }
                }
            }
            if (count($data) > 0) {
                $res = AdditionalAttachment::insert($data);
            }
        }
        if($res){
            return redirect()->route('admin.candidates.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.candidates.index')->with('error', 'Failed to update the data. Please try again.');
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

    public function getCandidatesDetails($id)
    {
        $candidate=Candidate::findOrFail($id);
        return response()->json($candidate);
    }

    public function getCandidatesSearch(Request $request)
    {
        $candidates=Candidate::where('candidate_name', 'like', '%' . $request->term . '%')->get(['id', 'candidate_name as text']);
        return ['results' => $candidates];
    }

    public function deleteAttachment($id)
    {
        $id=Crypt::decrypt($id);
        $attachment=AdditionalAttachment::findOrFail($id);
        $res=$attachment->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    
}
