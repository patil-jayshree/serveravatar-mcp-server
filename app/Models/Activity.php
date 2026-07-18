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

    protected $appends = ['type_label', 'time_ago', 'color', 'client_initials', 'client_color', 'client_logo', 'formatted_date'];

    const TYPE_CLIENT_CONNECTED = 'client_connected';
    const TYPE_TOOL_EXECUTED = 'tool_executed';
    const TYPE_API_KEY_SAVED = 'api_key_saved';
    const TYPE_API_KEY_UPDATED = 'api_key_updated';
    const TYPE_PROFILE_UPDATED = 'profile_updated';
    const TYPE_PASSWORD_CHANGED = 'password_changed';
    const TYPE_SETTINGS_UPDATED = 'settings_updated';
    const TYPE_TOKEN_CREATED = 'token_created';
    const TYPE_TOKEN_REVOKED = 'token_revoked';

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
        // Special case: tool_executed icon depends on success status
        if ($this->type === self::TYPE_TOOL_EXECUTED) {
            $success = $this->metadata['success'] ?? true;
            $color = $success ? '#3b82f6' : '#ef4444';
            return '<i class="fas fa-screwdriver-wrench" style="color: ' . $color . ';"></i>';
        }
        
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => '<i class="fa-solid fa-robot" style="color: #22c55e;"></i>',
            self::TYPE_API_KEY_SAVED => '<i class="fas fa-key" style="color: #8b5cf6;"></i>',
            self::TYPE_API_KEY_UPDATED => '<i class="fas fa-key" style="color: #f59e0b;"></i>',
            self::TYPE_PROFILE_UPDATED => '<i class="fas fa-user-pen" style="color: #06b6d4;"></i>',
            self::TYPE_PASSWORD_CHANGED => '<i class="fas fa-lock" style="color: #6366f1;"></i>',
            self::TYPE_SETTINGS_UPDATED => '<i class="fas fa-sliders" style="color: #64748b;"></i>',
            self::TYPE_TOKEN_CREATED => '<i class="fas fa-key" style="color: #22c55e;"></i>',
            self::TYPE_TOKEN_REVOKED => '<i class="fas fa-key" style="color: #ef4444;"></i>',
            default => '<i class="fas fa-circle-info" style="color: #94a3b8;"></i>',
        };
    }

    public function getBadgeAttribute(): string
    {
        // Special case: tool_executed badge depends on success status
        if ($this->type === self::TYPE_TOOL_EXECUTED) {
            $success = $this->metadata['success'] ?? true;
            return $success ? 'SUCCESS' : 'FAILED';
        }
        
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => 'CONNECTED',
            self::TYPE_API_KEY_SAVED => 'SAVED',
            self::TYPE_API_KEY_UPDATED => 'UPDATED',
            self::TYPE_PROFILE_UPDATED => 'UPDATED',
            self::TYPE_PASSWORD_CHANGED => 'SECURED',
            self::TYPE_SETTINGS_UPDATED => 'UPDATED',
            self::TYPE_TOKEN_CREATED => 'CREATED',
            self::TYPE_TOKEN_REVOKED => 'REVOKED',
            default => 'INFO',
        };
    }

    public function getColorAttribute(): string
    {
        // Special case: tool_executed color depends on success status
        if ($this->type === self::TYPE_TOOL_EXECUTED) {
            $success = $this->metadata['success'] ?? true;
            return $success ? 'info' : 'danger';
        }
        
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => 'success',
            self::TYPE_API_KEY_SAVED => 'primary',
            self::TYPE_API_KEY_UPDATED => 'warning',
            self::TYPE_PROFILE_UPDATED => 'cyan',
            self::TYPE_PASSWORD_CHANGED => 'primary',
            self::TYPE_SETTINGS_UPDATED => 'secondary',
            self::TYPE_TOKEN_CREATED => 'success',
            self::TYPE_TOKEN_REVOKED => 'danger',
            default => 'secondary',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            self::TYPE_CLIENT_CONNECTED => 'Client Connected',
            self::TYPE_TOOL_EXECUTED => 'Tool Executed',
            self::TYPE_API_KEY_SAVED => 'API Key Saved',
            self::TYPE_API_KEY_UPDATED => 'API Key Updated',
            self::TYPE_PROFILE_UPDATED => 'Profile Updated',
            self::TYPE_PASSWORD_CHANGED => 'Password Changed',
            self::TYPE_SETTINGS_UPDATED => 'Settings Updated',
            self::TYPE_TOKEN_CREATED => 'Token Created',
            self::TYPE_TOKEN_REVOKED => 'Token Revoked',
            default => 'Activity',
        };
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M j, Y • h:i A');
    }
    
    public function getClientInitialsAttribute(): string
    {
        $name = strtolower($this->client_name ?? '');
        if (!$name) return 'SA';
        if (strpos($name, 'chatgpt') !== false) return 'CG';
        if (strpos($name, 'claude') !== false) return 'CL';
        if (strpos($name, 'cursor') !== false) return 'CU';
        if (strpos($name, 'vscode') !== false) return 'VS';
        if (strpos($name, 'windsurf') !== false) return 'WS';
        if (strpos($name, 'perplexity') !== false) return 'PP';
        if (strpos($name, 'zed') !== false) return 'ZD';
        if (strpos($name, 'continue') !== false) return 'CT';
        if (strpos($name, 'gemini') !== false) return 'GM';
        if (strpos($name, 'mcp client') !== false) return 'MC';
        return strtoupper(substr($name, 0, 2));
    }

    public function getClientLogoAttribute(): ?array
    {
        $name = strtolower($this->client_name ?? '');
        if (strpos($name, 'chatgpt') !== false) {
            return ['light' => '/images/clients/chatgpt-light.png', 'dark' => '/images/clients/chatgpt-dark.png'];
        }
        if (strpos($name, 'claude') !== false) {
            return ['light' => '/images/clients/claude.png', 'dark' => '/images/clients/claude.png'];
        }
        if (strpos($name, 'cursor') !== false) {
            return ['light' => '/images/clients/cursor-light.png', 'dark' => '/images/clients/cursor-dark.png'];
        }
        if (strpos($name, 'vscode') !== false) {
            return ['light' => '/images/clients/vscode.png', 'dark' => '/images/clients/vscode.png'];
        }
        if (strpos($name, 'windsurf') !== false) {
            return ['light' => '/images/clients/windsurf-light.png', 'dark' => '/images/clients/windsurf-dark.png'];
        }
        if (strpos($name, 'perplexity') !== false) {
            return ['light' => '/images/clients/perplexity-light.png', 'dark' => '/images/clients/perplexity-dark.png'];
        }
        if (strpos($name, 'zed') !== false) {
            return ['light' => '/images/clients/zed.png', 'dark' => '/images/clients/zed.png'];
        }
        if (strpos($name, 'continue') !== false) {
            return ['light' => '/images/clients/continue.png', 'dark' => '/images/clients/continue.png'];
        }
        if (strpos($name, 'gemini') !== false) {
            return ['light' => '/images/clients/gemini.png', 'dark' => '/images/clients/gemini.png'];
        }
        return null;
    }
    
    public function getClientColorAttribute(): string
    {
        $name = strtolower($this->client_name ?? '');
        if (!$name) return '#8b5cf6';
        if (strpos($name, 'chatgpt') !== false) return '#10a37f';
        if (strpos($name, 'claude') !== false) return '#d97706';
        if (strpos($name, 'cursor') !== false) return '#22c55e';
        if (strpos($name, 'vscode') !== false) return '#007acc';
        if (strpos($name, 'windsurf') !== false) return '#6b7280';
        if (strpos($name, 'perplexity') !== false) return '#6366f1';
        if (strpos($name, 'zed') !== false) return '#22c55e';
        if (strpos($name, 'continue') !== false) return '#8b5cf6';
        if (strpos($name, 'gemini') !== false) return '#f59e0b';
        if (strpos($name, 'mcp client') !== false) return '#06b6d4';
        return '#8b5cf6';
    }

    public function getClientTypeAttribute(): string
    {
        $name = strtolower($this->client_name ?? '');
        if (!$name) return 'AI Client';
        if (strpos($name, 'chatgpt') !== false) return 'AI Clients';
        if (strpos($name, 'claude') !== false) return 'AI Clients';
        if (strpos($name, 'cursor') !== false) return 'AI IDE';
        if (strpos($name, 'vscode') !== false) return 'IDE';
        if (strpos($name, 'windsurf') !== false) return 'AI IDE';
        if (strpos($name, 'perplexity') !== false) return 'AI Clients';
        if (strpos($name, 'zed') !== false) return 'IDE';
        if (strpos($name, 'continue') !== false) return 'IDE Extension';
        if (strpos($name, 'gemini') !== false) return 'AI Clients';
        if (strpos($name, 'mcp client') !== false) return 'Web Application';
        return 'AI Client';
    }
}
