<?php

namespace Mvdnbrk\PostmarkWebhooks\Events;

class PostmarkWebhookCalled
{
    /** @var string */
    public $email;

    /** @var string */
    public $recordType;

    /** @var string */
    public $messageId;

    /** @var array */
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
