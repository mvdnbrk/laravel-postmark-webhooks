<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;
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
     * Store the result of a Postmark webhook and fire events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = config('postmark-webhooks.log.model');

        $postmarkWebhook = $model::createOrNewfromPayload($request->input());

        tap(new PostmarkWebhookCalled(
            $postmarkWebhook->email,
            $postmarkWebhook->record_type,
            $postmarkWebhook->message_id,
            $postmarkWebhook->payload
        ), function ($event) use ($postmarkWebhook) {
            event($event);
            event("webhook.postmark: {$postmarkWebhook->record_type}", $event);

            $dispatchEvent = config("postmark-webhooks.events.{$postmarkWebhook->record_type}");
            if ($dispatchEvent) {
                event(new $dispatchEvent($event));
            }
        });

        return response()->json()->setStatusCode(202);
    }
}
