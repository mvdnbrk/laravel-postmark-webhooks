<?php

namespace Mvdnbrk\PostmarkWebhooks\Events;

class PostmarkWebhookCalled
{
    /**
     * The email address.
     *
     * @var string
     */
    public $email;

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
     * @param  string  $recordTpe
     * @param  string  $messageId
     * @param  array  $payload
     * @return void
     */
    public function __construct($email, $recordType, $messageId, $payload)
    {
        $this->email = $email;
        $this->recordType = $recordType;
        $this->messageId = $messageId;
        $this->payload = $payload;
    }
}
