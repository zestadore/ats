<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    
    public function index(Request $request)
    {
        $type=0;
        if($request->type=="ToDos"){
            $type=1;
        }
        $html=$this->getNotes($type);
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
            $html=$this->getNotes($request->type);
            return response()->json(['success'=>"Data saved successfully!","html"=>$html]);
        }else{
            return response()->json(['error'=>"Something went wrong!"]);
        }
    }

    public function show(Note $note)
    {
        //
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $note=Note::with(['assignedTo'])->findOrFail($id);
        return $note;
    }

    public function update(Request $request, $id)
    {
        $id=Crypt::decrypt($id);
        $note=Note::findOrFail($id);
        $res=$note->update($request->except(['_token']));
        if($res){
            $html=$this->getNotes($request->type);
            return response()->json(['success'=>"Data saved successfully!","html"=>$html]);
        }else{
            return response()->json(['error'=>"Something went wrong!"]);
        }
    }

    public function destroy($id)
    {
        $id=Crypt::decrypt($id);
        $note=Note::findOrFail($id);
        $type=$note->type;
        $res=$note->delete();
        if($res){
            $html=$this->getNotes($type);
            return response()->json(['success'=>"Data deleted successfully!","html"=>$html]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    private function getNotes($type)
    {
        $notes=Note::where('type',$type)->latest('created_at')->get();
        $renderHtml=view('backend.notes.list',['notes'=>$notes,'type'=>$type])->render();
        return $renderHtml;
    }
}
