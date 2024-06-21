<?php

namespace App\Models;

use App\Traits\HasImage;
use App\Traits\HasStatus;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Item extends Model
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
        'cost',
        'price',
        'in_stock',
        'description',
        'category_id',
        'supplier_id',
        'unit',
        'is_active'
    ];

    const UNIT_GRAM = 1;
    const UNIT_COUNT = 2;
    const UNIT_MILILITER = 3;
    const UNIT_KILOGRAM = 4;

    public static $unitNames = [
        self::UNIT_GRAM => "UNIT_GRAM",
        self::UNIT_COUNT => "UNIT_COUNT",
        self::UNIT_MILILITER => "UNIT_MILILITER",
        self::UNIT_KILOGRAM => "UNIT_KILOGRAM",
    ];

    public static $unitValues = [
        self::UNIT_GRAM => "gr",
        self::UNIT_COUNT => "ps",
        self::UNIT_MILILITER => "ml",
        self::UNIT_KILOGRAM => "kg",
    ];

    public static function getUnit($id) {
        return Item::$unitValues[$id];
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
    
    public function getTableViewCostAttribute(): string
    {
        $hasExchangeRate = config('settings')->enableExchangeRateForItems;
        return currency_format($this->cost, $hasExchangeRate);
    }

    public function getTableViewPriceAttribute(): string
    {
        $hasExchangeRate = config('settings')->enableExchangeRateForItems;
        return currency_format($this->price, $hasExchangeRate);
    }
    
    public function getViewInStockAttribute(): string
    {
        return (string)$this->in_stock.Item::getUnit($this->unit);
    }
}
