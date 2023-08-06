<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class ValidateUser extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('user')??Crypt::encrypt(0);
        $id=Crypt::decrypt($id);
        return [
            'first_name' => 'required',
            'email' => 'required|unique:users,email,'. $id,
            'mobile' => 'required|unique:users,mobile,'. $id,
        ];
    }
}
