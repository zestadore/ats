<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateEmailSettings extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mail_type' => 'required',
            'mail_host'=>'required',
            'mail_port'=>'required',
            'mail_username'=>'required',
            'mail_password'=>'required',
            'mail_encryption'=>'required'
        ];
    }
}
