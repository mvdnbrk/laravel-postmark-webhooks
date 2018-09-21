<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhookLog;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = collect($request->input());

        PostmarkWebhookLog::create([
            'message_id' => $payload->get('MessageID'),
            'record_type' => snake_case($payload->get('RecordType')),
            'payload' => $payload->all(),
        ]);

        return response()->json()->setStatusCode(202);
    }
}
