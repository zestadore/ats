<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Client;
use App\Models\Candidate;
use App\Models\InvoiceDetails;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data= Invoice::query();
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
                ->addColumn('action', 'backend.invoices.action')
                ->make(true);
        }
        return view('backend.invoices.index');
    }

    public function create()
    {
        $clients=Client::get();
        $renderHtml=view('backend.invoices.add_more_rows')->render();
        $renderHtml = preg_replace("/[\r\n]*/","",$renderHtml);
        return view('backend.invoices.create',['clients'=>$clients,'renderHtml'=>$renderHtml]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'candidate_id' => 'required',
        ]);
        $data=[
            'client_id'=>Crypt::decrypt($request->client_id),
            'candidate_id'=>$request->candidate_id,
            'invoice_no'=>mt_rand(1000,99999),
            'invoice_date'=>now(),
            'due_date'=>Carbon::now()->addDays(5),
        ];
        $res=Invoice::create($data)->id;
        $resId=Crypt::encrypt($res);
        if($res){
            $x=Count($request->hours);
            $data=[];
            for($i=0;$i<$x;$i++){
                if($request->hours[$i]!=null && $request->from_date[$i]!=null && $request->to_date[$i]!=null && $request->rate[$i]!=null && $request->amount[$i]!=null){
                    $data[]=[
                        'invoice_id'=>$res,
                        'hours'=>$request->hours[$i],
                        'from_date'=>Carbon::parse($request->from_date[$i])->format('Y-m-d'),
                        'to_date'=>Carbon::parse($request->to_date[$i])->format('Y-m-d'),
                        'amount'=>$request->rate[$i],
                        'total_amount'=>$request->amount[$i],
                        'created_at'=>now(),
                    ];
                }
            }
            if(count($data)>0){
                $res=InvoiceDetails::insert($data);
            }
        }
        if($res){
            return redirect()->route('admin.invoices.show',$resId);
        }else{
            return redirect()->route('admin.invoices.index')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function show($id)
    {
        $data=Invoice::find(Crypt::decrypt($id));
        $company=Company::find($data->company_id);
        return view('backend.invoices.view',['data'=>$data,'company'=>$company]);
    }

    public function edit($id)
    {
        $clients=Client::get();
        $renderHtml=view('backend.invoices.add_more_rows')->render();
        $renderHtml = preg_replace("/[\r\n]*/","",$renderHtml);
        $data=Invoice::find(Crypt::decrypt($id));
        return view('backend.invoices.edit',['clients'=>$clients,'renderHtml'=>$renderHtml,'data'=>$data]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    public function destroy($id)
    {
        $data=Invoice::find(Crypt::decrypt($id));
        $res=$data->delete();
        if($res){
            return response()->json(['success'=>"Data deleted successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to delete the data, kindly try again!"]);
        }
    }

    public function addClient(Request $request)
    {
        $data=[
            'client_name'=>$request->client_name,
            'email'=>$request->email,
            'contact'=>"00000",
            'region'=>" "
        ];
        $res=Client::create($data);
        if($res){
            return response()->json(['success'=>"Data added successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to add the data, kindly try again!"]);
        }
    }

    public function addCandidate(Request $request)
    {
        $res=Candidate::create($request->except('_token'));
        if($res){
            return response()->json(['success'=>"Data added successfully!"]);
        }else{
            return response()->json(['error'=>"Failed to add the data, kindly try again!"]);
        }
    }

    public function publicInvoice($id)
    {
        $data=Invoice::find(Crypt::decrypt($id));
        $company=Company::find($data->company_id);
        return view('backend.invoices.public_invoice',['data'=>$data,'company'=>$company]);
    }

    public function downloadInvoice($id)
    {
        $data=Invoice::find(Crypt::decrypt($id));
        $company=Company::find($data->company_id);
        // share data to view
        view()->share('backend.invoices.public_invoice',$data);
        $pdf = PDF::loadView('backend.invoices.download_invoice', compact(['data','company']));
        // download PDF file with download method
        return $pdf->download('pdf_file.pdf');
    }

    public function mailInvoice($id,$email)
    {
        $data=Invoice::find(Crypt::decrypt($id));
        $company=Company::find($data->company_id);
        $adminEmail=User::where('role','company_admin')->where('company_id',$data->company_id)->first();
        Mail::to($email)->cc($adminEmail->email)->send(new InvoiceMail($data));
        return response()->json(['success'=>"Mail forwarded successfully!"]);
    }
}
