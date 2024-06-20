<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Expense extends Model
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

    protected static function boot()
    {
        parent::boot();
        Expense::creating(function ($model) {
            $latest = Expense::latest()->first();
            $strPadString = $latest ? (int)preg_replace("/[^0-9]/", "", $latest->number) + 1 : 1;
            $model->number = "E" . str_pad($strPadString, 6, "0", STR_PAD_LEFT);
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

    /**
     * Scope a query
     */
    public function scopeArchived(Builder $query): Builder
    {
        return $query->whereNotNull('archived_at');
    }

    /**
     * Scope a query
     */
    public function scopeNotArchived(Builder $query): Builder
    {
        return $query->whereNull('archived_at');
    }


    public function getAmountViewAttribute(): string
    {
        return currency_format($this->amount);
    }

    // public function getDateAttribute(): string
    // {
    //     $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
    //     $timeFormat = Settings::getValue(Settings::TIME_FORMATE);
    //     $timezone = Settings::getValue(Settings::TIMEZONE);
    //     return $this->created_at->timezone($timezone)->format("{$dateFormat} {$timeFormat}");
    // }

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


    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @param  string  $storagePath
     * @return void
     */
    public function storeReceipt(UploadedFile $receipt, $storagePath = 'receipts')
    {
        tap($this->receipt_path, function ($previous) use ($receipt, $storagePath) {
            $this->forceFill([
                'receipt_path' => $receipt->storePublicly(
                    $storagePath,
                    ['disk' => 'public']
                ),
            ])->save();
        });
    }


    /**
     * Get the URL to the user's profile photo.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function receiptUrl(): Attribute
    {
        return Attribute::get(function () {
            return $this->receipt_path
                ?  url("/storage/{$this->receipt_path}")
                : null;
        });
    }
}
