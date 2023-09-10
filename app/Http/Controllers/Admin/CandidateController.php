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
use Spatie\PdfToText\Pdf;

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
                        return "<a style='cursor: pointer;' href='".route('admin.get-candidate-matches',Crypt::encrypt($data->id))."'><label class='badge badge-primary-light'>".$count." Matches Found</label></a>";
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

    public function getMatches($id)
    {
        $candidate=Candidate::find(Crypt::decrypt($id));
        $matches=$candidate->opportunities()->paginate(25);
        return view('backend.candidates.matches',['candidate'=>$candidate,'matches'=>$matches]);
    }

    public function uploadAutoResume(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|max:2048|mimes:pdf',
        ]);
        if($request->file('resume')){
            $file= $request->file('resume');
            $original=$file->getClientOriginalName();
            $filename= date('YmdHi').$original;
            $originalName= pathinfo($original, PATHINFO_FILENAME);
            $file-> move(public_path('uploads/resumes'), $filename);
            $text = (new Pdf('c:/Program Files/Git/mingw64/bin/pdftotext'))
                ->setPdf(public_path('uploads/resumes/'.$filename))
                ->text();
            $emailId=$this->extractEmailId($text);
            $mobile=$this->extractContact($text);
            $data=['candidate_name'=>$originalName,'email'=>$emailId,'contact'=>$mobile,'resume'=>$filename];
            $res=Candidate::create($data)->id;
            if($res){
                return redirect()->route('admin.candidates.edit',Crypt::encrypt($res))->with('success', 'Successfully updated the data.');
            }else{
                return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
            }
        }
    }

    private function extractEmailId($text)
    {
        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
        preg_match_all($pattern, $text, $matches);
        return $matches[0][0]??null;
    }

    private function extractContact($text)
    {
        $pattern = '/\b[0-9]{3}\s*[-]?\s*[0-9]{3}\s*[-]?\s*[0-9]{4}\b/';
        preg_match_all($pattern, $text, $matches);
        return $matches[0][0]??null;
    }
}
