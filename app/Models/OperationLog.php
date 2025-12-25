<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationLog extends Model
{
    use HasFactory;

    protected $table = 'operation_logs';

    protected $fillable = [
        'operation_log_datetime',
        'screen_name',
        'user_id',
        'operation_name',
        'operation_type',
        'operation_value',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'operation_value' => 'array',
        'operation_log_datetime' => 'datetime',
    ];
}
