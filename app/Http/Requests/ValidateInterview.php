<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateInterview extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'interview_name' => 'required',
            'candidate_id' => 'required|numeric',
            'client_id'=>'required|numeric',
            'job_opportunity_id'=>'required|numeric',
            'from_date' => 'required|date',
            'to_date' => 'required|date'
        ];
    }
}
