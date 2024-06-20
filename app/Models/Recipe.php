<?php

namespace App\Models;

use App\Traits\HasImage;
use App\Traits\HasStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Recipe extends Model
{
    use HasFactory, HasUuid, HasImage, HasStatus;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var array<int, string>
    //  */
    protected $fillable = [
        'name',
        'image_path',
        'price',
        'description',
        'is_active'
    ];

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
    
    public function getTableViewPriceAttribute(): string
    {
        $hasExchangeRate = config('settings')->enableExchangeRateForItems;
        return currency_format($this->price, $hasExchangeRate);
    }
    
    public static function getCost(float $cost): string
    {
        $hasExchangeRate = config('settings')->enableExchangeRateForItems;
        return currency_format($cost, $hasExchangeRate);;
    }

    public function recipe_details()
    {
        return $this->hasMany(RecipeDetail::class);
    }
}
