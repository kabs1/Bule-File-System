<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeltRecord extends Model
{
    use HasFactory;

    protected $table = 'melt_records';
    protected $primaryKey = 'melt_id';

    protected $fillable = [
        'melt_weight',
        'date_created',
        'date_updated',
        'status',
        'inward_id',
        'stock_id',
        'user_id',
    ];

    protected $casts = [
        'date_created' => 'datetime',
        'date_updated' => 'datetime',
    ];
}
