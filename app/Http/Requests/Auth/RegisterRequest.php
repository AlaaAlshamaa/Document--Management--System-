<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:25',
            'last_name'  => 'required|string|max:24',
            'email'      => 'required|string|email|unique:users',
            'password'   => 'required|min:8',
        ];
    }
}
