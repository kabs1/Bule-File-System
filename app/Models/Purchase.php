<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'purchases';
    protected $primaryKey = 'puchase_id';

    protected $fillable = [
        'customer_id',
        'quantity',
        'price',
        'currency_id',
        'wallet_type',
        'wallet_stock_id',
        'date_recorded',
        'date_updated',
        'status',
        'user_id',
        'stock_id',
        'branch_id',
    ];

    protected $casts = [
        'date_recorded' => 'date',
        'date_updated' => 'date',
    ];
}
