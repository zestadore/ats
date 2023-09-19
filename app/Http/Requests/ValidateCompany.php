<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Rules\FreeEmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class ValidateCompany extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('company')??Crypt::encrypt(0);
        $id=Crypt::decrypt($id);
        if($id>0){
            $userId=User::where('company_id',$id)->firstorfail()->id??0;
        }else{
            $userId=0;
        }
        return [
            'company_name'=>'required',
            // 'date_format'=>'required',
            // 'time_zone'=>'required',
            // 'currency_symbol'=>'required',
            // 'currency_position'=>'required',
            // 'precision'=>'required',
            // 'pricing_plan_id'=>'required|numeric',
            'first_name'=>'required',
            'email' => 'required|email|unique:users,email,'. $userId,
            'email'=>new FreeEmailValidation,
            'mobile'=>'required|unique:users,mobile,'. $userId,
        ];
    }
}
