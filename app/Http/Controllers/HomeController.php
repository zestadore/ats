<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Candidate;
use App\Models\JobOpportunity;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.dashboard');    
    }

    public function authUserProfile()
    {
        return view('application.profile.profile');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
			'first_name' => 'required',
            'mobile'=>'required',
            'image'=>'nullable|mimes:jpeg,jpg,png|max:2048',
		]);
        $image=Auth::user()->image;
        $user=Auth::user();
        if($request->file('image')){
            if($user->image!=null){
                unlink(public_path('uploads/profiles/'. $user->image));
            }
            $file= $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('uploads/profiles'), $filename);
            $image= $filename;
        }
        $data=[
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'mobile'=>$request->mobile,
            'image'=>$image
        ];
        $res=$user->update($data);
        if($res){
            return redirect()->back()->with('success', 'Successfully updated the data.');
        }else{
            return redirect()->back()->with('error', 'Failed to update the data. Please try again.');
        }
    }

    public function changePassword()
    {
        return view('application.profile.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        $res=Auth::user()->update(['password'=>Hash::make($request->password)]);
        if($res){
            return redirect()->back()->with(['success'=>'Password updated successfully']);
        }else{
            return redirect()->back()->with(['error'=>'Failed to update the password']);
        }
    }

    public function updatePasswordProfile(Request $request)
    {
        $request->validate([
            'id'=> 'required',
        ]);
        $profile=User::find(Crypt::decrypt($request->id));
        $password=mt_rand(10000,100000);
        $res=$profile->update(['password'=>Hash::make($password)]);
        if($res){
            return response()->json(['success'=>"Data inserted successfully!",'message'=>'Password is ' . $password]);
        }else{
            return response()->json(['error'=>"Failed to insert the data, kindly try again!"]);
        }
    }

    public function updateCandidatesAI()
    {
        $data=JobOpportunity::get();
        foreach($data as $item){
            $skillArray=[];
                $notesSkillArray=[];
                $keyWords=$item->key_skills;
                $skillArray=explode(",",$keyWords);
                $keyWords=$item->notes;
                $notesSkillArray=explode(" ",$keyWords);
                $skillArray=array_merge($skillArray,$notesSkillArray);
                $idArray=[];
                foreach($skillArray as $skill){
                    if($skill!=Null and $skill!="" and $skill!=" "){
                        $ids=Candidate::where('key_skills', 'like', '%' . $skill . '%')->orWhere('skills', 'like', '%' . $skill . '%')->pluck('id')->toArray();
                        $idArray=array_merge($idArray,$ids);
                    }
                }
                $idArray=array_unique($idArray);
            $item->candidates()->attach($idArray);
        }
        dd($data);
    }
}
