<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     schema="Job",
 *     type="object",
 *     title="Job",
 *     required={"id", "title", "type"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Backend Developer"),
 *     @OA\Property(property="description", type="string", example="Develop APIs with Laravel", nullable=true),
 *     @OA\Property(property="type", type="string", enum={"PJ", "CLT", "Internship"}, example="CLT"),
 *     @OA\Property(property="salary", type="number", format="float", nullable=true),
 *     @OA\Property(property="hours", type="integer", nullable=true),
 *     @OA\Property(property="company_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-01-01T12:00:00Z")
 * )
 */
class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'salary',
        'hours',
        'company_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'job_user');
    }
}
