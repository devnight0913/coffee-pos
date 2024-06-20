<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuid;



    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'discount_view',
        'delivery_charge_view',
        'total_view',
        'date_view',
        'time_view',
        'tax_amount_view',
        'vat_view',
        'total_tax_view',
        'receipt_exchange_rate',
        'is_delivery',
        'subtotal_view'
    ];

    protected static function boot()
    {
        parent::boot();
        Order::creating(function ($model) {
            $latest = Order::latest()->first();
            $strPadString = $latest ? (int)preg_replace("/[^0-9]/", "", $latest->number) + 1 : 1;
            $model->number = "IN" . str_pad($strPadString, 6, "0", STR_PAD_LEFT);
        });
    }
    /**
     * Scope a query to search orders
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (!$search)  return $query;
        return $query->where('number', 'LIKE', "%{$search}%")
            ->orWhereHas('customer', function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%");
            });
    }

    /**
     * Scope a query
     */
    public function scopeOfAuthor(Builder $query, ?string $authorId): Builder
    {
        if (!$authorId)  return $query;
        return $query->where('user_id', $authorId);
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getCostAttribute(): float
    {
        return $this->order_details->sum('total_cost');
    }

    public function getCostViewAttribute(): string
    {
        return currency_format($this->cost);
    }

    public function getProfitAttribute(): float
    {
        return $this->total - $this->cost - $this->discount;
    }

    public function getProfitViewAttribute(): string
    {
        return currency_format($this->profit);
    }

    public function getChangeViewAttribute(): string
    {
        return $this->change > 0 ? currency_format($this->change) : "-";
    }

    public function getOweAttribute(): float
    {
        if ($this->tender_amount < $this->total) {
            return abs($this->tender_amount - $this->total);
        }
        return 0;
    }
    public function getOweViewAttribute(): string
    {
        return $this->owe > 0 ? currency_format($this->owe) :  "-";
    }
    public function getTenderAmountViewAttribute(): string
    {
        return currency_format($this->tender_amount);
    }

    public function getTotalViewAttribute(): string
    {
        return currency_format($this->total);
    }

    public function getReceiptExchangeRateAttribute(): string
    {
        $showExchangeRateOnReceipt = $this->show_exchange_rate;
        if (!$showExchangeRateOnReceipt) return '';
        if ($this->exchange_rate <= 0) return '';
        $value = $this->total * $this->exchange_rate;
        return custom_currency_format($value, $this->exchange_rate_currency);
    }


    public function getSubTotalViewAttribute(): string
    {
        return currency_format($this->subtotal);
    }
    public function getDiscountViewAttribute(): string
    {
        return $this->discount > 0 ? currency_format($this->discount) : "-";
    }
    public function getDeliveryChargeViewAttribute(): string
    {
        return $this->delivery_charge > 0 ? currency_format($this->delivery_charge) : "-";
    }

    public function getCustomerNameAttribute(): string
    {
        return $this->has_customer ? $this->customer->name : "-";
    }
    public function getAuthorNameAttribute(): string
    {
        return !is_null($this->user) ? $this->user->name : "-";
    }
    public function getHasCustomerAttribute(): bool
    {
        return !is_null($this->customer);
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
        return $this->created_at->timezone($timezone)->format("{$dateFormat}");
    }
    public function getTimeViewAttribute(): string
    {
        $timeFormat = Settings::getValue(Settings::TIME_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->created_at->timezone($timezone)->format("{$timeFormat}");
    }

    public function getTotalTaxAttribute(): float
    {
        return (($this->tax_rate * $this->subtotal) / 100);
    }
    public function getTotalTaxViewAttribute(): string
    {
        return currency_format($this->total_tax);
    }

    public function getTaxAmountViewAttribute(): string
    {
        return currency_format($this->tax_amount);
    }

    public function getTaxAmountAttribute(): float
    {
        if ($this->tax_rate <= 0) return 0;
        $grossAmount = $this->subtotal;
        $taxAmount = (1 + ($this->tax_rate / 100));
        $value = $grossAmount / $taxAmount;
        return (float)number_format($value, 0, '', '');
    }
    public function getVatViewAttribute(): string
    {
        return currency_format($this->vat);
    }
    public function getVatAttribute(): float
    {
        return $this->subtotal - $this->tax_amount;
    }

    public function getIsDeliveryAttribute(): bool
    {
        return $this->type == 'delivery';
    }


}
