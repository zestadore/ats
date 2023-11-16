<?php

namespace App\Http\Controllers;
use App\Http\Requests\ValidateCompany;
use App\Models\Company;
use App\Models\User;
use App\Models\PricingPlan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function companySignup()
    {
        $plans=PricingPlan::get();
        return view('application.profile.register',compact('plans'));
    }

    public function registerCompany(ValidateCompany $request)
    {
        if($request->file('logo')){
            $request->validate([
                'logo' => 'required|file|max:2048|mimes:jpg,jpeg,png,gif',
            ]);
        }
        $res=Company::create($request->except(['_token','first_name','email','mobile','password_string','last_name','logo']))->id;
        if($request->file('logo')){
            $file= $request->file('logo');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/logos'), $filename);
            $logo= $filename;
            if($res){
                Company::where('id',$res)->update(['logo'=>$logo]);
            }
        }
        if($res){
            $compId=$res;
            $res=Null;
            $data=[
                'company_id'=>$compId,
                'first_name'=>$request->first_name,
                'last_name'=>$request->last_name,
                'email'=>$request->email,
                'mobile'=>$request->mobile,
                'password'=>Hash::make($request->password_string??$request->mobile),
                'role'=>'company_admin'
            ];
            $res=$this->createUser($data);
        }
        if($res){
            Mail::to($request->email)->send(new EmailVerificationMail($res));
            return redirect()->route('login')->with('success', 'You have successfully registerred the company.');
        }else{
            return redirect()->route('login')->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function verifyEmail($id)
    {
        $id=Crypt::decrypt($id);
        $user=User::findOrFail($id);
        if($user->email_verified_at==Null){
            $res=$user->update(['email_verified_at'=>Now()]);
        }else{
            return redirect()->route('login')->with('success', 'You have already verified your email.');
        }
        if($res){
            return redirect()->route('login')->with('success', 'You have successfully verified your email.');
        }else{
            return redirect()->route('login')->with('error', 'Failed to verify your email.');
        }
    }

    private function createUser($data)
    {
        $res=User::create($data);
        return $res;
    }
}
