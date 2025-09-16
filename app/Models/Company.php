<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @OA\Schema(
 *     schema="Company",
 *     type="object",
 *     title="Company",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Acme Corporation"),
 *     @OA\Property(property="description", type="string", example="Leading tech company", nullable=true),
 *     @OA\Property(property="cnpj", type="string", example="12.345.678/0001-99", nullable=true),
 *     @OA\Property(property="plan", type="string", example="premium", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T12:00:00Z")
 * )
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'cnpj',
        'plan',
    ];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
