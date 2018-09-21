<?php

namespace Mvdnbrk\PostmarkWebhooks\Events;

class PostmarkWebhookCalled
{
    /**
     * The record type.
     *
     * @var string
     */
    public $recordType;

    /**
     * The message ID.
     *
     * @var string
     */
    public $messageId;

    /**
     * The payload from the webhook call.
     *
     * @var array
     */
    public $payload;

    /**
     * Create a new event instance.
     *
     * @param string  $recordTpe
     * @param string  $messageId
     * @param array  $payload
     * @return void
     */
    public function __construct($recordType, $messageId, $payload)
    {
        $this->recordType = $recordType;
        $this->messageId = $messageId;
        $this->payload = $payload;
    }
}
