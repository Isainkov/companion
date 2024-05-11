<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pet extends Model
{
    use HasFactory;

    const ENTITY_NAME = 'pet';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'age',
        'pet_type',
        'breed_type',
        'gender',
        'documents',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(PetType::class, 'pet_type');
    }

    /**
     * @return BelongsTo
     */
    public function breed(): BelongsTo
    {
        return $this->belongsTo(BreedType::class, 'breed_type');
    }
}
