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
    const TYPE_PROFILE_UPDATED = 'profile_updated';
    const TYPE_PASSWORD_CHANGED = 'password_changed';
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
            self::TYPE_CLIENT_CONNECTED => '<i class="fa-solid fa-robot" style="color: #22c55e;"></i>',
            self::TYPE_CLIENT_DISCONNECTED => '<i class="fa-solid fa-plug-circle-exclamation" style="color: #f59e0b;"></i>',
            self::TYPE_TOOL_EXECUTED => '<i class="fas fa-screwdriver-wrench" style="color: #3b82f6;"></i>',
            self::TYPE_API_KEY_SAVED => '<i class="fas fa-key" style="color: #8b5cf6;"></i>',
            self::TYPE_API_KEY_DELETED => '<i class="fas fa-trash" style="color: #ef4444;"></i>',
            self::TYPE_PROFILE_UPDATED => '<i class="fas fa-user-pen" style="color: #06b6d4;"></i>',
            self::TYPE_PASSWORD_CHANGED => '<i class="fas fa-lock" style="color: #6366f1;"></i>',
            self::TYPE_SETTINGS_UPDATED => '<i class="fas fa-sliders" style="color: #64748b;"></i>',
            default => '<i class="fas fa-circle-info" style="color: #94a3b8;"></i>',
        };
    }

    public function getBadgeAttribute(): string
    {
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => 'CONNECTED',
            self::TYPE_CLIENT_DISCONNECTED => 'DISCONNECTED',
            self::TYPE_TOOL_EXECUTED => 'EXECUTED',
            self::TYPE_API_KEY_SAVED => 'UPDATED',
            self::TYPE_API_KEY_DELETED => 'REMOVED',
            self::TYPE_PROFILE_UPDATED => 'UPDATED',
            self::TYPE_PASSWORD_CHANGED => 'SECURED',
            self::TYPE_SETTINGS_UPDATED => 'UPDATED',
            default => 'INFO',
        };
    }

    public function getColorAttribute(): string
    {
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => 'success',
            self::TYPE_CLIENT_DISCONNECTED => 'warning',
            self::TYPE_TOOL_EXECUTED => 'info',
            self::TYPE_API_KEY_SAVED => 'primary',
            self::TYPE_API_KEY_DELETED => 'danger',
            self::TYPE_PROFILE_UPDATED => 'cyan',
            self::TYPE_PASSWORD_CHANGED => 'primary',
            self::TYPE_SETTINGS_UPDATED => 'secondary',
            default => 'secondary',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => 'Client Connected',
            self::TYPE_CLIENT_DISCONNECTED => 'Client Disconnected',
            self::TYPE_TOOL_EXECUTED => 'Tool Executed',
            self::TYPE_API_KEY_SAVED => 'API Key Saved',
            self::TYPE_API_KEY_DELETED => 'API Key Deleted',
            self::TYPE_PROFILE_UPDATED => 'Profile Updated',
            self::TYPE_PASSWORD_CHANGED => 'Password Changed',
            self::TYPE_SETTINGS_UPDATED => 'Settings Updated',
            default => 'Activity',
        };
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }
}
