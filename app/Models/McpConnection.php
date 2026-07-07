<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class McpConnection extends Model
{
    protected $fillable = [
        'user_id',
        'client_name',
        'ip_address',
        'user_agent',
        'last_activity_at',
        'request_count',
        'tool_call_count',
        'success_count',
        'error_count',
        'total_response_time_ms',
        'first_request_at',
        'last_request_at',
    ];

    protected $casts = [
        'last_activity_at' => 'datetime',
        'first_request_at' => 'datetime',
        'last_request_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
