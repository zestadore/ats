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
        return [
            'company_name'=>'required',
            'first_name'=>'required',
            'email'=>new FreeEmailValidation,
        ];
    }
}
