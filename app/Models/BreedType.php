<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BreedType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    /**
     * @return HasMany
     */
    public function pet(): HasMany
    {
        return $this->hasMany(Pet::class, 'breed_type');
    }
}
