<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class McpRateLimiter
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $limiterName = 'api'): Response
    {
        $key = $this->resolveRequestSignature($request);
        $maxAttempts = $this->getMaxAttempts($limiterName);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = $this->limiter->availableIn($key);
            
            return response()->json([
                'error' => [
                    'code' => 429,
                    'message' => 'Too many requests. Please slow down and try again.',
                    'retry_after' => $retryAfter,
                ]
            ], 429);
        }

        $this->limiter->hit($key, 60);

        $response = $next($request);

        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', $this->limiter->remaining($key, $maxAttempts));

        return $response;
    }

    /**
     * Resolve request signature for rate limiting
     */
    protected function resolveRequestSignature(Request $request): string
    {
        if ($user = $request->user()) {
            return 'mcp:' . $user->id;
        }

        return 'mcp:' . $request->ip();
    }

    /**
     * Get max attempts based on limiter name
     */
    protected function getMaxAttempts(string $limiterName): int
    {
        return match($limiterName) {
            'mcp' => 60,
            'api' => 120,
            'auth' => 5,
            default => 60,
        };
    }
}
