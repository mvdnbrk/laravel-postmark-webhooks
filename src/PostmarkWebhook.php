<?php

namespace Mvdnbrk\PostmarkWebhooks;

use Illuminate\Database\Eloquent\Model;

class PostmarkWebhook extends Model
{
    /**
     * The name of the "updated at" column.
     * Set to null to disable this column.
     *
     * @var string
     */
    const UPDATED_AT = null;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * Create a new model instance..
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->table = config('postmark-webhooks.log.table_name', config('postmark-webhooks.log.table'));

        parent::__construct($attributes);
    }

    /**
     * Create a new model in the database.
     * If logging to the database is disabled
     * or the event type is excluded from logging
     * we will return a fresh instance.
     *
     * @param  array  $payload
     * @return \Mvdnbrk\PostmarkWebhooks\PostmarkWebhook
     */
    public static function createOrNewfromPayload($payload)
    {
        $payload = collect($payload);

        $recordType = snake_case($payload->get('RecordType'));

        $model = (new static)->forceFill([
            'email' => $payload->get('Recipient', $payload->get('Email')),
            'message_id' => $payload->get('MessageID'),
            'record_type' => $recordType,
            'payload' => $payload->all(),
        ]);

        if (config('postmark-webhooks.log.enabled')
            && ! collect(config('postmark-webhooks.log.except'))->contains($recordType)
        ) {
            $model->save();
        }

        return $model;
    }
}
