<?php

namespace App\Models;

use App\Traits\HasImage;
use App\Traits\HasStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class RecipeDetail extends Model
{
    use HasFactory, HasUuid, HasImage, HasStatus;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    protected $fillable = [
        'recipe_id',
        'item_id',
        'quantity'
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Scope a query to search Suppliers
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search)  return $query;
        return $query->where('name', 'LIKE', "%{$search}%");
    }

    protected static function boot(): void
    {
        parent::boot();
    }
}
