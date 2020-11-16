<?php

namespace Mvdnbrk\PostmarkWebhooks;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PostmarkWebhook extends Model
{
    /** @var string|null */
    const UPDATED_AT = null;

    /** @var array */
    protected $casts = [
        'payload' => 'array',
    ];

    public function __construct(array $attributes = [])
    {
        if (! isset($this->table)) {
            $this->setTable(config('postmark-webhooks.log.table_name'));
        }

        parent::__construct($attributes);
    }

    public static function createOrNewFromPayload(array $payload): self
    {
        $payload = collect($payload);

        $recordType = Str::snake($payload->get('RecordType'));

        $model = (new static)->forceFill([
            'email' => $payload->get('Recipient', $payload->get('Email')),
            'message_id' => $payload->get('MessageID'),
            'record_type' => $recordType,
            'payload' => $payload->all(),
        ]);

        if (config('postmark-webhooks.log.enabled') && ! collect(config('postmark-webhooks.log.except'))->contains($recordType)) {
            $model->save();
        }

        return $model;
    }
}
