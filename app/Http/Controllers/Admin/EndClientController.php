<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\EndClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DataTables;

class EndClientController extends Controller
{
    
    public function index($client_id,Request $request)
    {
        if ($request->ajax()) {
            $data= EndClient::query()->where('client_id',Crypt::decrypt($client_id));
            $search = $request->search;
            if ($search) {
                $data->where(function ($query) use ($search) {
                    $query->where('end_client', 'like', '%' . $search . '%');
                });
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'backend.clients.end_clients.action')
                ->make(true);
        }
        return view('backend.clients.end_clients.index',['client_id'=>$client_id]);
    }

    public function create($client_id)
    {
        return view('backend.clients.end_clients.create',['client_id'=>$client_id]);
    }

    public function store($client_id,Request $request)
    {
        $request->validate([
            'end_client' => 'required',
        ]);
        $res=EndClient::create($request->except(['_token']))->id;
        if($res){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show(EndClient $endClient)
    {
        //
    }

    public function edit($client_id,$id)
    {
        $id=Crypt::decrypt($id);
        $candidate=EndClient::findOrFail($id);
        return view('backend.clients.end_clients.edit',['data'=>$candidate,'client_id'=>$client_id]);
    }

    public function update($client_id,Request $request, $id)
    {
        $request->validate([
            'end_client' => 'required',
        ]);
        $id=Crypt::decrypt($id);
        $client=EndClient::findOrFail($id);
        $res=$client->update($request->except('_token'));
        if($res){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function destroy($client_id,$id)
    {
        $id=Crypt::decrypt($id);
        $client=EndClient::findOrFail($id);
        $res=$client->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    public function getList($id)
    {
        $endClients=EndClient::where('client_id',$id)->get();
        return response()->json($endClients);
    }
}
