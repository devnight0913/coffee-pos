<?php

use App\Models\Settings;

if (!function_exists('currency_format')) {
    function currency_format(float $number, bool $is_costume_currency = false): string
    {
        $settings = config('settings');

        $currencyThousandSeparator = $settings->currencyThousandSeparator;
        $currencyDecimalSeparator =  $settings->currencyDecimalSeparator;
        $showTrailingZeros =  $settings->trailingZeros;

        $formattedNumber = number_format(
            $number,
            $settings->currencyPrecision,
            is_null($currencyDecimalSeparator) ? ' ' : $currencyDecimalSeparator,
            is_null($currencyThousandSeparator) ? ' ' : $currencyThousandSeparator
        );
        if (!$showTrailingZeros) {
            $formattedNumber = str_replace("{$currencyDecimalSeparator}00", '', $formattedNumber);
        }
        $currency = $is_costume_currency ? Settings::getCurrency() :  $settings->currencySymbol;
        if ($settings->currencyPosition == "before") {
            return "{$currency} {$formattedNumber}";
        }
        return "{$formattedNumber} {$currency}";
    }
}
if (!function_exists('custom_currency_format')) {
    function custom_currency_format(float $number, string $currency = '$'): string
    {
        $formattedNumber = number_format($number, 2);
        return "{$currency}{$formattedNumber}";
    }
}
