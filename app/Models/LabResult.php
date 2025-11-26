<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
    use HasFactory;

    protected $table = 'lab_results';
    protected $primaryKey = 'record_id';

    protected $fillable = [
        'result',
        'status',
        'melt_id',
        'stock_id',
        'user_id',
    ];
}
