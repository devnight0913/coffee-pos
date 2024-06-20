<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrawerHistory extends Model
{
    use HasFactory, HasUuid;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'ended_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function getStartDateAttribute(): string
    {
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $timeFormat = Settings::getValue(Settings::TIME_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->created_at->timezone($timezone)->format("{$dateFormat} {$timeFormat}");
    }

    public function getDifferenceViewAttribute(): string
    {
        $difference = $this->difference;
        if ($difference < 0) {
            return "+ " . currency_format(abs($difference));
        }
        if ($difference > 0) {
            return "- " . currency_format(abs($difference));
        }
        return currency_format(0);
    }


    public function getEndDateAttribute(): string
    {
        $dateFormat = Settings::getValue(Settings::DATE_FORMATE);
        $timeFormat = Settings::getValue(Settings::TIME_FORMATE);
        $timezone = Settings::getValue(Settings::TIMEZONE);
        return $this->ended_at->timezone($timezone)->format("{$dateFormat} {$timeFormat}");
    }
}
