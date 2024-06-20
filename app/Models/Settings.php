<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
    ];


    const STORE_NAME = 1;
    const STORE_ADDRESS = 2;
    const STORE_PHONE_NUMBER = 3;
    const STORE_WEBSITE = 4;
    const STORE_EMAIL = 5;


    const DEFAULT_TAX_RATE = 6;
    const DEFAULT_DELIVERY_CHARGE = 7;
    const DEFAULT_DISCOUNT = 8;
    const NEW_ITEM_AUDIO = 9;

    const CURRENCY_SYMBOL = 10;
    const CURRENCY_POSITION = 11;
    const CURRENCY_THOUSAND_SEPARATOR = 12;
    const CURRENCY_DECIMAL_SEPARATOR = 13;
    const CURRENCY_PRECISION = 14;

    const DATE_FORMATE = 15;
    const TIME_FORMATE = 16;
    const TIMEZONE = 17;

    const STORE_ADDITIONAL_INFO = 18;
    const LANGUAGE = 19;
    const VAT_TYPE = 20;

    const EXCHANGE_RATE = 21;
    const EXCHANGE_CURRENCY = 22;

    const SHOW_TRAILING_ZEROS = 23;
    const SHOW_EXCHANGE_RATE_ON_RECEIPT = 24;
    const ENABLE_EXCHANGE_RATE_FOR_ITEMS = 25;
    const ENABLE_TAKEOUT_AND_DELIVERY = 26;
    const ENABLE_CASH_DRAWER = 27;
    const STARTING_CASH = 28;
    const SVG_LOGO = 29;


    public static $settingsNames = [
        self::STORE_NAME => "STORE_NAME",
        self::STORE_ADDRESS => "STORE_ADDRESS",
        self::STORE_PHONE_NUMBER => "STORE_PHONE_NUMBER",
        self::STORE_WEBSITE => "STORE_WEBSITE",
        self::STORE_EMAIL => "STORE_EMAIL",

        self::DEFAULT_TAX_RATE => "DEFAULT_TAX_RATE",
        self::DEFAULT_DELIVERY_CHARGE => "DEFAULT_DELIVERY_CHARGE",
        self::DEFAULT_DISCOUNT => "DEFAULT_DISCOUNT",
        self::NEW_ITEM_AUDIO => "NEW_ITEM_AUDIO",

        self::CURRENCY_SYMBOL => "CURRENCY_SYMBOL",
        self::CURRENCY_POSITION => "CURRENCY_POSITION",
        self::CURRENCY_THOUSAND_SEPARATOR => "CURRENCY_THOUSAND_SEPARATOR",
        self::CURRENCY_DECIMAL_SEPARATOR => "CURRENCY_DECIMAL_SEPARATOR",
        self::CURRENCY_PRECISION => "CURRENCY_PRECISION",

        self::DATE_FORMATE => "DATE_FORMATE",
        self::TIME_FORMATE => "TIME_FORMATE",
        self::TIMEZONE => "TIMEZONE",

        self::STORE_ADDITIONAL_INFO => "STORE_ADDITIONAL_INFO",
        self::LANGUAGE => "LANGUAGE",
        self::VAT_TYPE => "VAT_TYPE",

        self::EXCHANGE_RATE => "EXCHANGE_RATE",
        self::EXCHANGE_CURRENCY => "EXCHANGE_CURRENCY",
        self::SHOW_TRAILING_ZEROS => "SHOW_TRAILING_ZEROS",
        self::SHOW_EXCHANGE_RATE_ON_RECEIPT => "SHOW_EXCHANGE_RATE_ON_RECEIPT",
        self::ENABLE_EXCHANGE_RATE_FOR_ITEMS => "ENABLE_EXCHANGE_RATE_FOR_ITEMS",
        self::ENABLE_TAKEOUT_AND_DELIVERY => "ENABLE_TAKEOUT_AND_DELIVERY",
        self::ENABLE_CASH_DRAWER => "ENABLE_CASH_DRAWER",
        self::STARTING_CASH => "STARTING_CASH",
        self::SVG_LOGO => "SVG_LOGO",
    ];


    public static $settingsValues = [
        self::STORE_NAME => "SKY",
        self::STORE_ADDRESS => "Address",
        self::STORE_PHONE_NUMBER => "+961 XXXXXXXXX",
        self::STORE_WEBSITE => "",
        self::STORE_EMAIL => "email@example.com",

        self::DEFAULT_TAX_RATE => 0,
        self::DEFAULT_DELIVERY_CHARGE => 0,
        self::DEFAULT_DISCOUNT => 0,
        self::NEW_ITEM_AUDIO => false,

        self::CURRENCY_SYMBOL => "$",
        self::CURRENCY_POSITION => "before",
        self::CURRENCY_THOUSAND_SEPARATOR => ",",
        self::CURRENCY_DECIMAL_SEPARATOR => ".",
        self::CURRENCY_PRECISION => 2,

        self::DATE_FORMATE => "d/m/Y",
        self::TIME_FORMATE => "H:i",
        self::TIMEZONE => "Asia/Beirut",

        self::STORE_ADDITIONAL_INFO => "",
        self::LANGUAGE => "en",
        self::VAT_TYPE => "exclude",

        self::EXCHANGE_RATE => 1,
        self::EXCHANGE_CURRENCY => "€",

        self::SHOW_TRAILING_ZEROS => true,
        self::SHOW_EXCHANGE_RATE_ON_RECEIPT => false,
        self::ENABLE_EXCHANGE_RATE_FOR_ITEMS => false,
        self::ENABLE_TAKEOUT_AND_DELIVERY => false,
        self::ENABLE_CASH_DRAWER => true,
        self::STARTING_CASH => 0.00,
        self::SVG_LOGO => null,
    ];

    public static function getValue(int $id)
    {
        return Settings::find($id)->value;
    }

    public static function updateValue(int $id, $value)
    {
        return Settings::find($id)->update(['value' => $value]);
    }

    public static function getValues(): object
    {
        $settings = Settings::all()->keyBy('id');
        $lang = $settings[Settings::LANGUAGE]->value;
        $dir = $lang == 'ar' ? 'rtl' : 'ltr';
        $margin = $dir == 'rtl' ? 'margin-right' : 'margin-left';
        return (object)[
            'logo' => $settings[Settings::SVG_LOGO]->value,
            'storeName' => $settings[Settings::STORE_NAME]->value,
            'storeAddress' => $settings[Settings::STORE_ADDRESS]->value,
            'storePhone' => $settings[Settings::STORE_PHONE_NUMBER]->value,
            'storeWebsite' => $settings[Settings::STORE_WEBSITE]->value,
            'storeEmail' => $settings[Settings::STORE_EMAIL]->value,
            'storeAdditionalInfo' => $settings[Settings::STORE_ADDITIONAL_INFO]->value,
            'lang' => $lang,
            'dir' => $dir,
            'margin' => $margin,

            'taxRate' => (float)$settings[Settings::DEFAULT_TAX_RATE]->value,
            'vatType' => $settings[Settings::VAT_TYPE]->value,
            'deliveryCharge' => (float)$settings[Settings::DEFAULT_DELIVERY_CHARGE]->value,
            'discount' => (float)$settings[Settings::DEFAULT_DISCOUNT]->value,
            'newItemAudio' => (bool)$settings[Settings::NEW_ITEM_AUDIO]->value,

            'timezone' => $settings[Settings::TIMEZONE]->value,
            'dateFormat' => $settings[Settings::DATE_FORMATE]->value,
            'timeFormat' => $settings[Settings::TIME_FORMATE]->value,

            'currencyName' => self::currencyName($settings[Settings::CURRENCY_SYMBOL]->value),

            'currencySymbol' => $settings[Settings::CURRENCY_SYMBOL]->value,
            'currencyPosition' => $settings[Settings::CURRENCY_POSITION]->value,
            'currencyThousandSeparator' => $settings[Settings::CURRENCY_THOUSAND_SEPARATOR]->value,
            'currencyDecimalSeparator' => $settings[Settings::CURRENCY_DECIMAL_SEPARATOR]->value,
            'currencyPrecision' => (int)$settings[Settings::CURRENCY_PRECISION]->value,

            'trailingZeros' => (bool)$settings[Settings::SHOW_TRAILING_ZEROS]->value,
            'showExchangeRateOnReceipt' => (bool)$settings[Settings::SHOW_EXCHANGE_RATE_ON_RECEIPT]->value,
            'enableExchangeRateForItems' => (bool)$settings[Settings::ENABLE_EXCHANGE_RATE_FOR_ITEMS]->value,
            'exchangeRate' => (float)$settings[Settings::EXCHANGE_RATE]->value,
            'exchangeCurrency' => $settings[Settings::EXCHANGE_CURRENCY]->value,
            'enableTakeoutAndDelivery' => (bool)$settings[Settings::ENABLE_TAKEOUT_AND_DELIVERY]->value,
            'enableCashDrawer' => (bool)$settings[Settings::ENABLE_CASH_DRAWER]->value,
            'startingCash' => (float)$settings[Settings::STARTING_CASH]->value,
            'productCurrency' => self::getProductCurrency(
                (bool)$settings[Settings::ENABLE_EXCHANGE_RATE_FOR_ITEMS]->value,
                $settings[Settings::EXCHANGE_CURRENCY]->value,
                $settings[Settings::CURRENCY_SYMBOL]->value,
            ),
        ];
    }

    public static function getProductCurrency(bool $hasExchangeRate, string $exchangeCurrency, string $currencySymbol): string | null
    {
        if ($hasExchangeRate) {
            return $exchangeCurrency;
        }
        return $currencySymbol;
    }



    public static function getCurrency()
    {
        $hasExchangeRate = config('settings')->enableExchangeRateForItems;
        if ($hasExchangeRate) {
            return config('settings')->exchangeCurrency;
        }
        return config('settings')->currencySymbol;
    }
    public static function getDefaultCurrency()
    {
        return config('settings')->currencySymbol;
    }

    public static function currencyName(string $currencySymbol = "$")
    {
        if ($currencySymbol == "$") return "US Dollar";
        if ($currencySymbol == "€") return "Euro";
        if ($currencySymbol == "LBP") return "Lebanese Pound";
        return "-";
    }
}
