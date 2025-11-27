<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';

    public function getRouteKeyName(): string
    {
        return 'customer_id';
    }

    protected $fillable = [
        'first_name',
        'last_name',
        'contact',
        'email',
        'branch_id',
        'status',
        'user_id', // Renamed from created_by_user_id for simplicity, assuming it refers to the creating user
    ];

    protected $casts = [
        // 'date_created' => 'datetime', // Laravel's timestamps handle this
        // 'date_updated' => 'datetime', // Laravel's timestamps handle this
    ];

    /**
     * Get the user who created this customer.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the branch that the customer belongs to.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'branch_id');
    }

    /**
     * Get the customer's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    /**
     * Get the name of the user who created the customer.
     */
    public function getCreatedByAttribute(): string
    {
        return $this->creator ? $this->creator->first_name . ' ' . $this->creator->last_name : 'N/A';
    }

    /**
     * Get the name of the branch the customer belongs to.
     */
    public function getBranchNameAttribute(): string
    {
        return $this->branch ? $this->branch->branch_name : 'N/A';
    }
}
