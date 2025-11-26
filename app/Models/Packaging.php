<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packaging extends Model
{
    use HasFactory;

    protected $table = 'packaging';
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'group_id',
        'count',
        'gross_weight',
        'current_weight',
        'remit_weight',
        'loss_gain',
        'sample',
        'net_weight',
        'x_summary',
        's_summary',
        'date_recorded',
        'date_updated',
        'status',
        'user_id',
        'stock_id',
        'branch_id',
    ];

    protected $casts = [
        'date_recorded' => 'datetime',
        'date_updated' => 'datetime',
    ];
}
