<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Controllers;

use Illuminate\Routing\Controller;
use Mvdnbrk\PostmarkWebhooks\Http\Middleware\PostmarkIpsWhitelist;

class PostmarkWebhooksController extends Controller
{
    /**
     * Create a controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware([
            'api',
            PostmarkIpsWhitelist::class,
        ]);
    }

    /**
     * Store the result of a Postmark webhook.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        return response()->json()->setStatusCode(202);
    }
}
