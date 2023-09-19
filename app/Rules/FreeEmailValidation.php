<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FreeEmailValidation implements ValidationRule
{
    
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $parts = explode('@', $value);
        $email = $parts[1];
        $url =public_path('assets/free_email_provider_domains.txt');
        $json = file_get_contents($url);
        if (preg_match("/{$email}/i", $json)) {
            $fail('Please use your business email!.');
        }
    }
}
