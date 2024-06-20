<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use DateTime;
use DateTimeZone;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function show(): View
    {
        $settings = Settings::all()->keyBy('id');

        return view('settings.show', 
        [
            'storeName' => $settings[Settings::STORE_NAME]->value,
            'storeAddress' => $settings[Settings::STORE_ADDRESS]->value,
            'storePhone' => $settings[Settings::STORE_PHONE_NUMBER]->value,
            'storeWebsite' => $settings[Settings::STORE_WEBSITE]->value,
            'storeEmail' => $settings[Settings::STORE_EMAIL]->value,
            'storeAdditionalInfo' => $settings[Settings::STORE_ADDITIONAL_INFO]->value,
            'language' => $settings[Settings::LANGUAGE]->value,
            'timezones' => $this->timezone_list(),


            'taxRate' => $settings[Settings::DEFAULT_TAX_RATE]->value,
            'vatType' => $settings[Settings::VAT_TYPE]->value,
            'deliveryCharge' => $settings[Settings::DEFAULT_DELIVERY_CHARGE]->value,
            'discount' => $settings[Settings::DEFAULT_DISCOUNT]->value,
            'newItemAudio' => $settings[Settings::NEW_ITEM_AUDIO]->value,


            'currencySymbol' => $settings[Settings::CURRENCY_SYMBOL]->value,
            'currencyPosition' => $settings[Settings::CURRENCY_POSITION]->value,
            'currencyThousandSeparator' => $settings[Settings::CURRENCY_THOUSAND_SEPARATOR]->value,
            'currencyDecimalSeparator' => $settings[Settings::CURRENCY_DECIMAL_SEPARATOR]->value,
            'currencyPrecision' => $settings[Settings::CURRENCY_PRECISION]->value,


            'dateFormat' => $settings[Settings::DATE_FORMATE]->value,
            'timeFormat' => $settings[Settings::TIME_FORMATE]->value,
            'timezone' => $settings[Settings::TIMEZONE]->value,

            'exchangeRateCurrencySymbol' => $settings[Settings::EXCHANGE_CURRENCY]->value,
            'exchangeRateValue' => $settings[Settings::EXCHANGE_RATE]->value,

            'trailing_zeros' => $settings[Settings::SHOW_TRAILING_ZEROS]->value,
            'showExchangeRateOnReceipt' => $settings[Settings::SHOW_EXCHANGE_RATE_ON_RECEIPT]->value,
            'enableExchangeRateForItems' => $settings[Settings::ENABLE_EXCHANGE_RATE_FOR_ITEMS]->value,
            'enableTakeoutAndDelivery' => (bool)$settings[Settings::ENABLE_TAKEOUT_AND_DELIVERY]->value,
            'enableCashDrawer' => (bool)$settings[Settings::ENABLE_CASH_DRAWER]->value,
        ]
    );
    }
    public function updateDate(Request $request): RedirectResponse
    {
        $request->validate([
            'date_format' => ['required', 'string'],
            'time_format' => ['required', 'string'],
            'timezone' => ['required', 'string'],
        ]);
        Settings::updateValue(Settings::DATE_FORMATE, $request->date_format);
        Settings::updateValue(Settings::TIME_FORMATE, $request->time_format);
        Settings::updateValue(Settings::TIMEZONE, $request->timezone);

        return Redirect::back()->with("success", __("Settings has been updated"));
    }


    public function updateCurrency(Request $request): RedirectResponse
    {
        $request->validate([
            'currency_symbol' => ['required', 'string', 'max:4'],
            'currency_position' => ['nullable', 'string'],
            'currency_thousand_separator' => ['nullable', 'string', 'max:1'],
            'currency_decimal_separator' => ['nullable', 'string', 'max:1'],
            'currency_precision' => ['nullable', 'integer', 'min:0', 'max:5'],
            'currency_precision' => ['nullable', 'integer', 'min:0', 'max:5'],
        ]);
        Settings::updateValue(Settings::CURRENCY_SYMBOL, $request->currency_symbol);
        Settings::updateValue(Settings::CURRENCY_POSITION, $request->currency_position);
        Settings::updateValue(Settings::CURRENCY_THOUSAND_SEPARATOR, $request->currency_thousand_separator);
        Settings::updateValue(Settings::CURRENCY_DECIMAL_SEPARATOR, $request->currency_decimal_separator);
        Settings::updateValue(Settings::CURRENCY_PRECISION, $request->currency_precision);
        Settings::updateValue(Settings::SHOW_TRAILING_ZEROS, $request->has('trailing_zeros'));

        return Redirect::back()->with("success", __("Settings has been updated"));
    }



    public function updateIdentification(Request $request): RedirectResponse
    {
        $request->validate([
            'store_name' => ['required', 'string', 'max:100'],
            'store_address' => ['nullable', 'string', 'max:100'],
            'store_phone' => ['nullable', 'string', 'max:60'],
            'store_website' => ['nullable', 'string', 'max:100'],
            'store_email' => ['nullable', 'string', 'max:30'],
            'store_additional_info' => ['nullable', 'string', 'max:100'],
            'store_additional_info' => ['nullable', 'string', 'max:150'],
        ]);
        Settings::updateValue(Settings::STORE_NAME, $request->store_name);
        Settings::updateValue(Settings::STORE_ADDRESS, $request->store_address);
        Settings::updateValue(Settings::STORE_PHONE_NUMBER, $request->store_phone);
        Settings::updateValue(Settings::STORE_WEBSITE, $request->store_website);
        Settings::updateValue(Settings::STORE_EMAIL, $request->store_email);
        Settings::updateValue(Settings::STORE_ADDITIONAL_INFO, $request->store_additional_info);
        Settings::updateValue(Settings::LANGUAGE, $request->lang);
        Settings::updateValue(Settings::SVG_LOGO, $request->logo);

        return Redirect::back()->with("success", __("Settings has been updated", [], $request->lang ?? 'en'));
    }


    public function updatePos(Request $request): RedirectResponse
    {

        $request->validate([
            'tax_rate' => ['required', 'numeric', 'min:0'],
            'vat_type' => ['required', 'string'],
            'delivery_charge' => ['required', 'numeric', 'min:0'],
            'discount' => ['required', 'numeric', 'min:0'],
        ]);

        Settings::updateValue(Settings::DEFAULT_TAX_RATE, $request->tax_rate);
        Settings::updateValue(Settings::VAT_TYPE, $request->vat_type);
        Settings::updateValue(Settings::DEFAULT_DELIVERY_CHARGE, $request->delivery_charge);
        Settings::updateValue(Settings::DEFAULT_DISCOUNT, $request->discount);
        Settings::updateValue(Settings::NEW_ITEM_AUDIO, $request->has('newItemAudio'));
        Settings::updateValue(Settings::ENABLE_TAKEOUT_AND_DELIVERY, $request->has('enableTakeoutAndDelivery'));
        Settings::updateValue(Settings::ENABLE_CASH_DRAWER, $request->has('enableCashDrawer'));


        return Redirect::back()->with("success", __("Settings has been updated"));
    }

    public function updateExchangeRate(Request $request): RedirectResponse
    {
        $request->validate([
            'exchange_rate_value' => ['required', 'numeric', 'min:0'],
            'exchange_rate_currency_symbol' => ['required', 'string'],
        ]);

        Settings::updateValue(Settings::EXCHANGE_RATE, $request->exchange_rate_value);
        Settings::updateValue(Settings::EXCHANGE_CURRENCY, $request->exchange_rate_currency_symbol);
        Settings::updateValue(Settings::SHOW_EXCHANGE_RATE_ON_RECEIPT, $request->has('showExchangeRateOnReceipt'));
        Settings::updateValue(Settings::ENABLE_EXCHANGE_RATE_FOR_ITEMS, $request->has('enableExchangeRateForItems'));

        return Redirect::back()->with("success", __("Settings has been updated"));
    }



    public function updateStartingCashValue(Request $request)
    {
        $request->validate([
            'value' => ['nullable', 'numeric', 'min:0'],
        ]);
        Settings::updateValue(Settings::STARTING_CASH, $request->value);
        return $this->jsonResponse();
    }


    
    private function timezone_list()
    {
        static $timezones = null;

        if ($timezones === null) {
            $timezones = [];
            $offsets = [];
            $now = new DateTime('now', new DateTimeZone('UTC'));

            foreach (DateTimeZone::listIdentifiers() as $timezone) {
                $now->setTimezone(new DateTimeZone($timezone));
                $offsets[] = $offset = $now->getOffset();
                $timezones[$timezone] = '(' . $this->format_GMT_offset($offset) . ') ' .  $this->format_timezone_name($timezone);
            }

            array_multisort($offsets, $timezones);
        }

        return $timezones;
    }

    private function format_GMT_offset($offset)
    {
        $hours = intval($offset / 3600);
        $minutes = abs(intval($offset % 3600 / 60));
        return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
    }

    private function format_timezone_name($name)
    {
        $name = str_replace('/', ', ', $name);
        $name = str_replace('_', ' ', $name);
        $name = str_replace('St ', 'St. ', $name);
        return $name;
    }
}
