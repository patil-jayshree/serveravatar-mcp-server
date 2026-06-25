<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, CanResetPassword;

    protected $fillable = [
        'name',
        'email',
        'password',
        'serveravatar_user_id',
        'serveravatar_access_token',
        'serveravatar_refresh_token',
        'serveravatar_token_expires_at',
        'api_key',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'serveravatar_access_token',
        'serveravatar_refresh_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'serveravatar_token_expires_at' => 'datetime',
            'api_key_updated_at' => 'datetime',
        ];
    }

    public function oauthTokens()
    {
        return $this->hasMany(OAuthToken::class);
    }

    public function hasApiKey(): bool
    {
        return !empty($this->api_key) 
            && $this->api_key !== 'PLACEHOLDER' 
            && strpos($this->api_key, '•') === false;
    }

    public function hasServerAvatarOAuth(): bool
    {
        return !empty($this->serveravatar_access_token) 
            && (!$this->serveravatar_token_expires_at || $this->serveravatar_token_expires_at->isFuture());
    }
}
