<?php

namespace Zeevx\Superban\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SuperbanMiddleware
{
    public function handle(Request $request, Closure $next, $maxAttempt, $decaySeconds, $banSeconds)
    {
        $superban_key = config('superban.key');
        $superban_guard = config('superban.user_guard');
        $superban_cache = config('superban.cache');
        $email_address = config('superban.email_address');
        $enable_email_notification = config('superban.enable_email_notification');

        if (!is_null($superban_cache)){
            config(['cache.limiter' => $superban_cache]);
        }
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
        if (Cache::driver($superban_cache)->get("superban-{$key}")){
            throw new HttpException( 403, 'Access forbidden.',  null);
        }
        if (RateLimiter::remaining($key, $maxAttempt)) {
            RateLimiter::hit($key, $decaySeconds);
            return $next($request);
        }
        if(Cache::driver($superban_cache)->put("superban-{$key}", true, now()->addSeconds($banSeconds))){
            $date = now()->toDateTimeString();
            if($enable_email_notification && ! is_null($email_address)){
                Mail::raw("
                You are receiving this automated email because a user got banned. \n
                User key > {$key} \n
                Url > {$request->url()} \n
                Date & Time > {$date} \n
                Regards, Superban
                ", static function (Message $message) use ($email_address) {
                    $message->subject('Superban Notification🚨')->to($email_address);
                });
            }
        }
        throw new HttpException( 429, 'Too Many Attempts.',  null);
    }
}
