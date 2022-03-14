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

    public function __construct(string $email, string $recordType, ?string $messageId, array $payload)
    {
        $this->email = $email;
        $this->recordType = $recordType;
        $this->messageId = $messageId;
        $this->payload = $payload;
    }
}
