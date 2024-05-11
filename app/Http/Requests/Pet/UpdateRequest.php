<?php

namespace App\Http\Requests\Pet;

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
            'description' => 'string|max:255',
            'price' => 'numeric',
            'age' => 'numeric',
            'pet_type' => 'numeric|exists:App\Models\Pet,id',
            'breed_type.*' => 'numeric|exists:App\Models\BreedType,id',
            'gender' => 'string',
            'documents' => 'string|max:255',
            'image.*' => 'file|mimes:jpg,jpeg,png,svg',
            'user_id' => 'numeric|exists:App\Models\User,id',
        ];
    }
}
