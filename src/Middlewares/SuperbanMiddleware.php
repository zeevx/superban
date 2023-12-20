<?php

namespace Zeevx\Superban\Middlewares;

use Closure;
use InvalidArgumentException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SuperbanMiddleware
{
    public function handle(Request $request, Closure $next, $maxAttempt, $decaySeconds)
    {
        if(is_null($maxAttempt)) {
            throw new InvalidArgumentException('Missing max attempt parameter for superban middleware');
        }
        if(is_null($decaySeconds)) {
            throw new InvalidArgumentException('Missing decay seconds parameter for superban middleware');
        }
        $superban_key = config('superban.key');
        $superban_guard = config('superban.user_guard');
        if (is_null($superban_guard)){
            $superban_guard = null;
        }
        if ($superban_key === 'user_id') {
            $key =  $request->user($superban_guard)->id ?? $request->ip();
        } elseif ($superban_key === 'email') {
            $key =  $request->user($superban_guard)->email ?? $request->ip();
        } else {
            $key = $request->ip();
        }
        $superban_cache = config('superban.cache');
        if (!is_null($superban_cache)){
            config(['cache.limiter' => $superban_cache]);
        }
        if (RateLimiter::remaining($key, $maxAttempt)) {
            RateLimiter::hit($key, $decaySeconds);
            return $next($request);
        }
        throw new HttpException( 429, 'Too Many Attempts.',  null);
    }

    public static function using($maxAttempt, $decaySeconds)
    {
        return static::class.':'.implode(',', func_get_args());
    }

}
