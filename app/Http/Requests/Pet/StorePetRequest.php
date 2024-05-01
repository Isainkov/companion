<?php

namespace App\Http\Requests\Pet;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

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
            'animal_type' => 'required|numeric|exists:App\Models\Pet,id',
            'breed_type' => 'numeric|exists:App\Models\Breed,id',
            'gender' => 'string',
            'documents' => 'string|max:255',
            'image' => 'file',
        ];
    }
}
