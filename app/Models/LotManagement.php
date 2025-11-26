<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotManagement extends Model
{
    use HasFactory;

    protected $table = 'lot_management';
    protected $primaryKey = 'lot_id';

    protected $fillable = [
        'lot_code',
        'lot_description',
        'date_created',
        'date_updated',
        'status',
        'user_id',
        'branch_id',
    ];

    protected $casts = [
        'date_created' => 'datetime',
        'date_updated' => 'datetime',
    ];
}
