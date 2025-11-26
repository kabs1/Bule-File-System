<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MeasureUnit extends Model
{
    use LogsActivity;
    protected $table = 'measure_units';
    protected $primaryKey = 'id';

    protected $fillable = [
        'unit_name',
        'unit_symbol',
        'date_created',
        'date_updated',
        'user_id',
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
