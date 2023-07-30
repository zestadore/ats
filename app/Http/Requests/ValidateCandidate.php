<?php

namespace App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Foundation\Http\FormRequest;

class ValidateCandidate extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('candidate')??Crypt::encrypt(0);
        $id=Crypt::decrypt($id);
        return [
            'candidate_name' => 'required',
            'email' => 'required|unique:candidates,email,'. $id,
            'location'=>'required',
            'contact'=>'required',
            'visa_status'=>'required',
            'job_title'=>'required'
        ];
    }
}
