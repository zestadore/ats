<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateSubmission extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'job_title_id' => 'required|numeric',
            'candidate_id' => 'required|numeric'
        ];
    }
}
