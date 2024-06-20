<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    public function getDateAttribute(): string
    {
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->created_at->timezone($timezone)->format("{$dateFormat}");
    }
    public function getBalanceViewAttribute(): string
    {
        $transactions = self::where('customer_id', $this->customer_id)->where('id', '<', $this->id);
        $balance = $transactions->sum('credit') - $transactions->sum('debit') + ($this->credit - $this->debit);
        if ($balance < 0) return "(" . currency_format(abs($balance)) . ")";
        if ($balance == 0) return currency_format(0);
        return currency_format(abs($balance));
    }

    public function getDebitViewAttribute(): string | null
    {
        $debit = abs($this->debit);
        if ($debit == 0) return "-";
        return currency_format(abs($this->debit));
    }


    public function getCreditViewAttribute(): string | null
    {
        $credit = abs($this->credit);
        if ($credit == 0) return "-";
        return currency_format(abs($this->credit));
    }
}
