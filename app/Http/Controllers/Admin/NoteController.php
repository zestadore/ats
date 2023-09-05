<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    
    public function index()
    {
        $html=$this->getNotes();
        return response()->json(["html"=>$html]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $res=Note::create($request->except(['_token']));
        if($res){
            $html=$this->getNotes();
            return response()->json(['success'=>"Data saved successfully!","html"=>$html]);
        }else{
            return response()->json(['error'=>"Something went wrong!"]);
        }
    }

    public function show(Note $note)
    {
        //
    }

    public function edit(Note $note)
    {
        //
    }

    public function update(Request $request, Note $note)
    {
        //
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $note=Note::findOrFail($id);
        $res=$note->delete();
        if($res){
            $html=$this->getNotes();
            return response()->json(['success'=>"Data deleted successfully!","html"=>$html]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    private function getNotes()
    {
        $notes=Note::latest('created_at')->get();
        $renderHtml=view('backend.notes.list',['notes'=>$notes])->render();
        return $renderHtml;
    }
}
