<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory, HasUuid;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public static $modes = [
        'Cash',
        'Check',
        'Credit Card',
        'Bank Transfer',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
    ];
    protected static function boot()
    {
        parent::boot();
        Payment::creating(function ($model) {
            $latest = Payment::latest()->first();
            $strPadString = $latest ? (int)preg_replace("/[^0-9]/", "", $latest->number) + 1 : 1;
            $model->number = "P" . str_pad($strPadString, 6, "0", STR_PAD_LEFT);
        });
    }
    /**
     * Scope a query to search orders
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search)  return $query;
        return $query->where('number', 'LIKE', "%{$search}%");
    }


    public function getAmountViewAttribute(): string
    {
        return currency_format($this->amount);
    }
    public function getCreatedAtViewAttribute(): string
    {
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $timeFormat = Settings::getValue(Settings::TIME_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->created_at->timezone($timezone)->format("{$dateFormat} {$timeFormat}");
    }
    public function getDateViewAttribute(): string
    {
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->date->timezone($timezone)->format("{$dateFormat}");
    }
    public function getTimeViewAttribute(): string
    {
        $timeFormat = Settings::getValue(Settings::TIME_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->created_at->timezone($timezone)->format("{$timeFormat}");
    }
}
