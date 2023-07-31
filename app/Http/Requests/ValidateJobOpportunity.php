<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateJobOpportunity extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'type' => 'required',
            'client_id'=>'required|numeric',
            'end_client_id'=>'required|numeric'
        ];
    }
}
