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
        'name',
        'short_name',
    ];

    protected $casts = [
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
