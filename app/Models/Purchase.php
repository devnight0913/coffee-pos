<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Purchase extends Model
{
    use HasFactory, HasUuid;


    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];
    /**
     * Scope a query to search orders
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search)  return $query;
        return $query->where('number', 'LIKE', "%{$search}%");
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function purchase_details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    protected static function boot()
    {
        parent::boot();
        Purchase::creating(function ($model) {
            $latest = Purchase::latest()->first();
            $strPadString = $latest ? (int)preg_replace("/[^0-9]/", "", $latest->number) + 1 : 1;
            $model->number = "PO" . str_pad($strPadString, 6, "0", STR_PAD_LEFT);
        });
    }

    public function getDateViewAttribute(): string
    {
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->date->timezone($timezone)->format("{$dateFormat}");
    }
}
