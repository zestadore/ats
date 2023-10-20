<?php
namespace App\Classes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HelperClass {
    
    public function getRolesList(){
        $role=Auth::user()->role;
        $roleArray=[];
        switch($role){
            case 'super_admin':
                $roleArray=[
                    [
                        'id' => 'recruiter',
                        'text'=> 'Recruiter',
                    ],
                    [
                        'id' => 'account_manager',
                        'text'=> 'Account Manager',
                    ],
                    [
                        'id' => 'team_lead',
                        'text'=> 'Team Lead',
                    ]
                ];
                break;
            case 'company_admin':
                    $roleArray=[
                        [
                            'id' => 'recruiter',
                            'text'=> 'Recruiter',
                        ],
                        [
                            'id' => 'account_manager',
                            'text'=> 'Account Manager',
                        ],
                        [
                            'id' => 'team_lead',
                            'text'=> 'Team Lead',
                        ]
                    ];
                    break;
            case 'account_manager':
                $roleArray=[
                    [
                        'id' => 'recruiter',
                        'text'=> 'Recruiter',
                    ]
                ];
                break;
            case 'team_lead':
                $roleArray=[
                    [
                        'id' => 'recruiter',
                        'text'=> 'Recruiter',
                    ],
                    [
                        'id' => 'account_manager',
                        'text'=> 'Account Manager',
                    ]
                ];
                break;
        }
        return $roleArray;
    }

    public function getRelatedUsers(){
        $rolesList=$this->getRolesList();
        $role=Auth::user()->role;
        if($role=='super_admin'){
            $users=User::where('id','!=',Auth::user()->id)->get();
            return $users;
        }else{
            $roles=[];
            foreach($rolesList as $rolez){
                $roles[]=$rolez['id'];
            }
            $users=User::where('id','!=',Auth::user()->id)->whereIn('role',$roles)->get();
            return $users;
        }
    }

}