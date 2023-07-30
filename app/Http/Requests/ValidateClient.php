<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class ValidateClient extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('client')??Crypt::encrypt(0);
        $id=Crypt::decrypt($id);
        return [
            'client_name' => 'required',
            'email' => 'required|unique:clients,email,'. $id,
            'region'=>'required',
            'contact'=>'required',
        ];
    }
}
