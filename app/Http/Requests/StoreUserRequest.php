<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //max 255 char 
            // Rules\Password::defaults()
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['sometimes', 'string','required_without:phone', 'email', 'max:255', 'unique:users'],
            'phone' => ['sometimes','unique:users','required_without:email','regex:/^[0-9]{10}$/'],
            'password' => ['required','min:6'],
        ];
    }
}
