<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'age' => $this->age,
            'pet_type' => $this->type?->name,
            'breed_types' => $this->has('breeds') ? $this->breeds->pluck('name') : null,
            'gender' => $this->gender,
            'documents' => $this->documents,
            'user_id' => $this->user_id,
            'images' => $this->images ? explode(',', $this->images) : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
