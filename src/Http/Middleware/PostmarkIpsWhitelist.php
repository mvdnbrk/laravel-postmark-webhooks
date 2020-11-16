<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Middleware;

use Closure;

class PostmarkIpsWhitelist
{
    /**
     * Array of IP addresses from Postmark that are white listed.
     * @see https://postmarkapp.com/support/article/800-ips-for-firewalls#webhooks
     *
     * @var array
     */
    private $ips = [
        '127.0.0.1',
        '3.134.147.250',
        '18.217.206.57',
        '50.31.156.6',
        '50.31.156.77',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (collect($this->ips)->contains($request->getClientIp())) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
