<?php
namespace App\Classes;
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

}