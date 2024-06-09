<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }

    public function comments() : HasMany
    {
        return $this->hasMany(Comment::class, 'recipe_id', 'id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipe_tag');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function countAverageRatingForRecipe(): float|int|null
    {
        $averageRating = $this->comments->avg('rate');
        return $averageRating !== null ? round($averageRating, 1) : null;
    }
}
