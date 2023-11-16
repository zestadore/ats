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
            'price_per_user' => 'required|numeric',
        ];
    }
}
