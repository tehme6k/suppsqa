<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    /** @use HasFactory<\Database\Factories\InventoryFactory> */
    use HasFactory;

    protected $guarded = [];

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M d, Y H:i A'); // Example format
    }

    public function getFormattedExpirationDateAttribute()
    {
        return $this->expiration_date->format('M d, Y'); // Example format
    }

    public function getWhereLocationIsQuarantineAttribute()
    {
        return $this->facility_location === 'quarantine';
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function quarantineUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'quarantine_user');
    }

    public function approveUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_user');
    }
}
