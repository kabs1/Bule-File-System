<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends SpatieRole
{
    use HasFactory;
    use LogsActivity;

    protected $primaryKey = 'id';
    protected string $guard_name = 'web';

    protected $fillable = [
        'role_name',
        'date_recorded',
        'date_updated',
        'user_id',
        'status',
        'name',
        'guard_name',
    ];

    protected $casts = [
        'date_recorded' => 'datetime',
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
