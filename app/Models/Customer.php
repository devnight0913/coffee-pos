<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'birthday',
        'gender',
        'nationality',
        'civil_status',
        'email',
        'telephone',
        'mobile',
        'fax',
        'street_address',
        'building',
        'floor',
        'apartment',
        'city',
        'state',
        'country',
        'zip_code',
        'tax_identification_number',
        'notes',
        'company_name',
        'company_street_address',
        'company_city',
        'company_state',
        'company_country',
        'company_zip_code'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function order_details()
    {
        return $this->hasManyThrough(OrderDetail::class, Order::class);
    }
    protected static function boot()
    {
        parent::boot();
        Customer::creating(function ($model) {
            $latest = Customer::latest()->first();
            $strPadString = $latest ? (int)preg_replace("/[^0-9]/", "", $latest->number) + 1 : 1;
            $model->number = "C" . str_pad($strPadString, 6, "0", STR_PAD_LEFT);
        });
    }



    /**
     * Scope a query to search posts
     */
    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        return $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('number',  'LIKE', "%{$search}%")
            ->orWhere('email',  'LIKE', "%{$search}%")
            ->orWhere('mobile',  'LIKE', "%{$search}%")
            ->orWhere('telephone',  'LIKE', "%{$search}%");
    }



    public function getOwedAmountAttribute(): string
    {
        $change = $this->orders->where('change', '<', '0')->sum('change');
        $payments = $this->payments->sum('amount');
        $owe = abs($change) - $payments;
        if ($owe < 0) return currency_format(0);
        return currency_format(abs($owe));
    }
    public function getPaymentAmountAttribute(): string
    {
        return currency_format($this->payments->sum('amount'));
    }
    public function getTotalPaymentsAttribute()
    {
        return $this->payments->count();
    }
    public function getPurchaseAmountAttribute(): string
    {
        $purchaseAmount = $this->orders->sum('total');
        return $purchaseAmount <= 0 ? currency_format(0) : currency_format($purchaseAmount);
    }
    public function getTotalOrdersAttribute()
    {
        return $this->orders->count();
    }

    public function getIsMaleAttribute(): bool
    {
        return $this->gender == "male";
    }

    public function getIsFemaleAttribute(): bool
    {
        return $this->gender == "female";
    }

    public function getDebitAttribute(): string
    {
        $transactions = $this->transactions();
        $debit_sum = $transactions->sum('debit');
        $credit_sum = $transactions->sum('credit');
        $balance_sum = $credit_sum - $debit_sum;
        $balance = $balance_sum;
        if ($balance < 0) return currency_format(abs($balance));
        return currency_format(0);
    }

    public function getBalanceAttribute(): string
    {
        $transactions = $this->transactions();
        $debit_sum = $transactions->sum('debit');
        $credit_sum = $transactions->sum('credit');
        $balance_sum = $credit_sum - $debit_sum;
        $balance = $balance_sum;
        if ($balance < 0) return "(" . currency_format(abs($balance)) . ")";
        if ($balance == 0) return currency_format(0);
        return currency_format(abs($balance));
    }

    public function getPrintNameAttribute(): string
    {
        $nameArray = [];
        if (!is_null($this->name)) {
            $nameArray['name'] = $this->name;
        }
        if (!is_null($this->company_name)) {
            $nameArray['company_name'] = $this->company_name;
        }
        return implode(' - ', $nameArray);
    }

    public function getContactAttribute(): string
    {
        $contactArray = [];
        if (!is_null($this->mobile)) {
            $contactArray['mobile'] = $this->mobile;
        }
        if (!is_null($this->telephone)) {
            $contactArray['telephone'] = $this->telephone;
        }
        if (!is_null($this->email)) {
            $contactArray['email'] = $this->email;
        }
        return implode(', ', $contactArray);
    }

    public function getFullAddressAttribute(): string
    {
        $addressArray = [];
        if (!is_null($this->city)) {
            $addressArray['city'] = __('City') . ": " . $this->city;
        }
        if (!is_null($this->street_address)) {
            $addressArray['street_address'] = __('Street') . ": " . $this->street_address;
        }
        if (!is_null($this->building)) {
            $addressArray['building'] = __('Building') . ": " . $this->building;
        }
        if (!is_null($this->floor)) {
            $addressArray['floor'] = __('Floor') . ": " . $this->floor;
        }
        if (!is_null($this->apartment)) {
            $addressArray['apartment'] = __('Apartment') . ": " . $this->apartment;
        }
        return implode(', ', $addressArray);
    }
    public function getPrintAddressAttribute(): string
    {
        $addressArray = [];
        if (!is_null($this->city)) {
            $addressArray['city'] = $this->city;
        }
        if (!is_null($this->street_address)) {
            $addressArray['street_address'] = $this->street_address;
        }
        if (!is_null($this->state)) {
            $addressArray['state'] = $this->state;
        }
        if (!is_null($this->zip_code)) {
            $addressArray['zip_code'] = $this->zip_code;
        }
        if (!is_null($this->country)) {
            $addressArray['country'] = $this->country;
        }
        return implode(', ', $addressArray);
    }
    public function getCompanyAddressAttribute(): string
    {
        $addressArray = [];

        if (!is_null($this->company_street_address)) {
            $addressArray['company_street_address'] = $this->company_street_address;
        }
        if (!is_null($this->company_city)) {
            $addressArray['company_city'] = $this->company_city;
        }
        if (!is_null($this->company_state)) {
            $addressArray['company_state'] = $this->company_state;
        }
        if (!is_null($this->company_zip_code)) {
            $addressArray['company_zip_code'] = $this->company_zip_code;
        }
        if (!is_null($this->company_country)) {
            $addressArray['company_country'] = $this->company_country;
        }
        return implode(', ', $addressArray);
    }
}
