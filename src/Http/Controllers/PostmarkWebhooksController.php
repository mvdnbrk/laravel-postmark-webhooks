<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Controllers;

use Illuminate\Routing\Controller;

class PostmarkWebhooksController extends Controller
{
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
