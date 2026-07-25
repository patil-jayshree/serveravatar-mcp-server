<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Mcp\Events\SessionInitialized;
use App\Models\McpConnection;
use App\Models\Activity;
use App\Services\McpConnectionTracker;
use Laravel\Passport\Token;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Suppress tempnam warning from filesystem
        error_reporting(E_ALL & ~E_WARNING);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadViewsFrom(resource_path('views/vendor/passport'), 'passport');
        Passport::authorizationView('passport::authorize');
        Passport::tokensExpireIn(now()->addYear());
        Passport::refreshTokensExpireIn(now()->addYears(2));
        Passport::personalAccessTokensExpireIn(now()->addYear());

        // Listen for MCP Session Initialized to capture correct client name
        $this->app['events']->listen(SessionInitialized::class, function (SessionInitialized $event) {
            $clientName = $event->clientName();
            if ($clientName && $clientName !== 'MCP Client') {
                // Try to get user from McpConnectionTracker (set during middleware)
                $user = McpConnectionTracker::getCurrentUser();
                
                // If not available, try to get from bearer token in request
                if (!$user && request()) {
                    $authHeader = request()->header('Authorization');
                    if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
                        $bearerToken = trim(substr($authHeader, 7));
                        $tokenId = $this->extractTokenId($bearerToken);
                        if ($tokenId) {
                            $accessToken = Token::find($tokenId);
                            if ($accessToken) {
                                $user = $accessToken->user;
                            }
                        }
                    }
                }

                if ($user) {
                    // Update any recent "MCP Client" entries for this user to the actual name
                    McpConnection::where('user_id', $user->id)
                        ->where('client_name', 'MCP Client')
                        ->where('last_activity_at', '>', now()->subMinutes(5))
                        ->update(['client_name' => $clientName]);

                    // Also update the activity log
                    Activity::where('user_id', $user->id)
                        ->where('client_name', 'MCP Client')
                        ->where('type', Activity::TYPE_CLIENT_CONNECTED)
                        ->where('created_at', '>', now()->subMinutes(5))
                        ->update([
                            'client_name' => $clientName,
                            'description' => "Connected successfully via {$clientName}"
                        ]);
                }
            }
        });

        // Share timezone list to all views
        $timezone_list = \App\Helpers\TimezoneHelper::getAll();
        view()->share('timezoneList', $timezone_list);

        // Set timezone for dates from authenticated user (affects format())
        if (auth()->check() && auth()->user()->timezone) {
            date_default_timezone_set(auth()->user()->timezone);
        }

        // Blade helper: convert any date to user's timezone
        \Blade::directive('usertime', function ($date) {
            return "<?php echo ($date)->timezone(config('app.timezone'))->diffForHumans(); ?>";
        });

        \Blade::directive('usertimeabs', function ($date) {
            return "<?php echo ($date)->timezone(config('app.timezone'))->format('M d, Y'); ?>";
        });
    }

    private function extractTokenId(string $bearerToken): ?string
    {
        $parts = explode('.', $bearerToken);
        if (count($parts) === 3) {
            $payload = json_decode($this->base64url_decode($parts[1]), true);
            if (!$payload || !isset($payload['jti'])) {
                return null;
            }
            if (isset($payload['exp']) && $payload['exp'] < time()) {
                return null;
            }
            return $payload['jti'];
        }
        if (str_contains($bearerToken, '|')) {
            $idPart = explode('|', $bearerToken)[0];
            return $idPart ?: null;
        }
        return $bearerToken ?: null;
    }

    private function base64url_decode(string $data): string
    {
        $remainder = strlen($data) % 4;
        if ($remainder) {
            $data .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($data, '-_', '+/'));
    }
}
