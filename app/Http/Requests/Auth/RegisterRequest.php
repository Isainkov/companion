<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\AbstractRequest;
use App\Models\User;
use Illuminate\Validation\Rules\Password as PasswordRules;
use Illuminate\Contracts\Validation\Validator;

class RegisterRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', PasswordRules::defaults()],
        ];
    }

    /**
     * @param Validator $validator
     * @return mixed
     * @throws \Exception
     */
    protected function failedValidation(Validator $validator)
    {
        return response()->json($validator->errors(), 422);
    }
}
