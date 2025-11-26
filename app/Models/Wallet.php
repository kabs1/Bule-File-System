<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';
    protected $primaryKey = 'wallet_id';

    protected $fillable = [
        'customer_id',
        'wallet_type',
        'inwardmeltweight',
        'date_recorded',
        'date_updated',
        'status',
        'user_id',
        'branch_id',
    ];

    protected $casts = [
        'date_recorded' => 'date',
        'date_updated' => 'date',
    ];
}
