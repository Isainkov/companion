<?php

namespace App\Http\Requests\Review;

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
            'receiver_profile_id' => 'required|exists:users,id',
            'sender_profile_id' => 'required|exists:users,id',
            'rating' => 'required|numeric|between:0,5',
            'comment' => 'string',
        ];
    }
}
