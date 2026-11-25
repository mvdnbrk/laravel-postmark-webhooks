<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PostmarkIpsWhitelist
{
    /**
     * Array of IP addresses from Postmark that are white listed.
     *
     * @see https://postmarkapp.com/support/article/800-ips-for-firewalls#webhooks
     *
     * @var array
     */
    private $ips = [
        '3.134.147.250',
        '18.217.206.57',
        '50.31.156.6',
        '50.31.156.77',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (app()->environment('local')) {
            return $next($request);
        }

        if (collect($this->ips)->contains($request->getClientIp())) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
