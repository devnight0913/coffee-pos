<?php

namespace App\Traits;

use App\Facades\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Lang;

trait HasStatus
{

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the status.
     *
     * @return string
     */
    public function getStatusAttribute(): string
    {
        return $this->is_active ? __("Available") : __("Unavailable");
    }


    /**
     * Get the status badge bg color.
     *
     * @return string
     */
    public function getStatusBadgeBgColorAttribute(): string
    {
        return $this->is_active ? "bg-primary" : "bg-danger";
    }
}
