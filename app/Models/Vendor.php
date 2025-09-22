<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y H:i A'); // Example format
    }

    public function inventories(): HasMany
    {
        return $this->hasMany(Inventory::class);
    }
}
