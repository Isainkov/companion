<?php

namespace App\Http\Requests\User;

use App\Http\Requests\AbstractRequest;

class UpdateRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255',
            'image' => 'file|mimes:jpg,jpeg,png,svg',
            'rating' => 'float|between:0,5',
            'amount_of_reviews' => 'integer',
            'country' => 'string|max:255',
            'city' => 'string|max:255',
            'pets_ids' => 'array',
            'phone' => 'string|max:255',
            'socials' => 'array',
        ];
    }
}
