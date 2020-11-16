<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;

class PostmarkWebhooksController extends Controller
{
    /**
     * Store the result of a Postmark webhook and fire events.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
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

            if ($dispatchEvent = config("postmark-webhooks.events.{$postmarkWebhook->record_type}")) {
                event(new $dispatchEvent($event));
            }
        });

        return response()->json()->setStatusCode(202);
    }
}
