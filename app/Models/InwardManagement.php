<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InwardManagement extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'inward_management';
    protected $primaryKey = 'inward_id';

    protected $fillable = [
        'inward_code',
        'customer_id',
        'date_created',
        'date_updated',
        'comments',
        'status',
        'user_id',
        'branch_id',
        'lot_id',
    ];

    protected $casts = [
        'date_created' => 'datetime',
        'date_updated' => 'datetime',
    ];
}
