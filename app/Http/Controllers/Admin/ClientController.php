<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ValidateClient;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class ClientController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Client::query();
            $search = $request->search;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('client_name', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'backend.clients.action')
                ->make(true);
        }
        return view('backend.clients.index');
    }

    public function create()
    {
        return view('backend.clients.create');
    }

    public function store(ValidateClient $request)
    {
        $res=Client::create($request->except('_token'));
        if($res){
            return redirect()->route('admin.clients.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.clients.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show($id)
    {
        $res=Client::find(Crypt::decrypt($id));
        if($res){
            return response()->json(['success'=>true,'data'=>$res]);
        }else{
            return response()->json(['success'=>false,'data'=>Null]);
        }
    }

    public function edit($id)
    {
        $id=Crypt::decrypt($id);
        $client=Client::findOrFail($id);
        return view('backend.clients.edit',['data'=>$client]);
    }

    public function update(ValidateClient $request, $id)
    {
        $id=Crypt::decrypt($id);
        $client=Client::findOrFail($id);
        $res=$client->update($request->except('_token'));
        if($res){
            return redirect()->route('admin.clients.index')->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->route('admin.clients.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function destroy( $id)
    {
        $id=Crypt::decrypt($id);
        $client=Client::findOrFail($id);
        $res=$client->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }
}
