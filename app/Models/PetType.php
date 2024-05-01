<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PetType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * @return HasOne
     */
    public function type(): HasOne
    {
        return $this->hasOne(Pet::class, 'pet_type');
    }
}
