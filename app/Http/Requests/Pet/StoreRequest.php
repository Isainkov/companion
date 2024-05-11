<?php

namespace App\Http\Requests\Pet;

use App\Http\Requests\AbstractRequest;

class StoreRequest extends AbstractRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'price' => 'numeric',
            'age' => 'required|numeric',
            'pet_type' => 'required|numeric|exists:App\Models\Pet,id',
            'breed_type' => 'numeric|exists:App\Models\Breed,id',
            'gender' => 'string',
            'documents' => 'string|max:255',
            'image.*' => 'file|mimes:jpg,jpeg,png,svg',
            'user_id' => 'required|numeric|exists:App\Models\User,id',
        ];
    }
}
