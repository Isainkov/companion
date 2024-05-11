<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BreedType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * @return BelongsToMany
     */
    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(
            Pet::class,
            'breed_type_pet',
            'breed_type_id',
            'pet_id'
        );
    }
}
