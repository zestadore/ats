<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidatePricingPlan extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'plan_name' => 'required',
            'plan_type' => 'required',
            'price' => 'required|numeric',
            'plan_interval'=>'required|numeric',
            'maximum_users'=>'required|numeric',
            'monthly_invoices'=>'required|numeric',
        ];
    }
}
