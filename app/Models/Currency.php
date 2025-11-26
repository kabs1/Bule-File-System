<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Currency extends Model
{
    use LogsActivity;
    protected $primaryKey = 'id';

    protected $fillable = [
        'currency_name',
        'currency_symbol',
        'date_created',
        'date_updated',
        'user_id',
        // 'is_default',
    ];

    protected $casts = [
        'date_created' => 'datetime',
        'date_updated' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
