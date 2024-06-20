<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getViewQuantityAttribute() 
    {
        $units = ["gr", "ps", "ml", "kg"];
        return "".$this->quantity.$units[$this->item->unit - 1];
    }
}
