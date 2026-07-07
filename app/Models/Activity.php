<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'description',
        'metadata',
        'client_name',
        'ip_address',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    const TYPE_CLIENT_CONNECTED = 'client_connected';
    const TYPE_CLIENT_DISCONNECTED = 'client_disconnected';
    const TYPE_TOOL_EXECUTED = 'tool_executed';
    const TYPE_API_KEY_SAVED = 'api_key_saved';
    const TYPE_API_KEY_DELETED = 'api_key_deleted';
    const TYPE_SETTINGS_UPDATED = 'settings_updated';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    public function getIconAttribute(): string
    {
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => '➡️',
            self::TYPE_CLIENT_DISCONNECTED => '⬅️',
            self::TYPE_TOOL_EXECUTED => '🔧',
            self::TYPE_API_KEY_SAVED => '🔑',
            self::TYPE_API_KEY_DELETED => '🗑️',
            self::TYPE_SETTINGS_UPDATED => '⚙️',
            default => '📌',
        };
    }

    public function getBadgeAttribute(): string
    {
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => 'success',
            self::TYPE_TOOL_EXECUTED => 'info',
            self::TYPE_API_KEY_SAVED => 'success',
            self::TYPE_CLIENT_DISCONNECTED => 'warning',
            self::TYPE_API_KEY_DELETED, self::TYPE_SETTINGS_UPDATED => 'danger',
            default => 'secondary',
        };
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
