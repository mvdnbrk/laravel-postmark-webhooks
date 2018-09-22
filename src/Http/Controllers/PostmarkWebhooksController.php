<?php

namespace Mvdnbrk\PostmarkWebhooks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mvdnbrk\PostmarkWebhooks\PostmarkWebhookLog;
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
        $payload = collect($request->input());

        $messageId = $payload->get('MessageID');
        $recordType = snake_case($payload->get('RecordType'));
        $email = collect([
            'bounce' => $payload->get('Email'),
            'spam_complaint' => $payload->get('Email'),
        ])->get($recordType, $payload->get('Recipient'));

        PostmarkWebhookLog::create([
            'email' => $email,
            'message_id' => $messageId,
            'record_type' => $recordType,
            'payload' => $payload->all(),
        ]);

        tap(new PostmarkWebhookCalled(
            $email,
            $recordType,
            $messageId,
            $payload->all()
        ), function ($event) use ($recordType) {
            event($event);
            event("webhook.postmark: {$recordType}", $event);
        });

        return response()->json()->setStatusCode(202);
    }
}
