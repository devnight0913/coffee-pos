<?php

namespace App\Traits;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;



trait Availability
{
    function isAvailable(string $status): bool
    {
        return Str::lower($status) == Str::lower("available");
    }
}
