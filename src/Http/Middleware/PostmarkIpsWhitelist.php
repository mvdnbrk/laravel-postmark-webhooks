<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Middleware;

use Closure;

class PostmarkIpsWhitelist
{
    /**
     * Array of IP addresses from Postmark that are white listed.
     *
     * @see https://postmarkapp.com/support/article/800-ips-for-firewalls#webhooks
     *
     * @var array
     */
    private $ips = config('postmark-webhooks.allowlist-ips')

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
