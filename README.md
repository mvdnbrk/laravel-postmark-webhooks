<p align="center"><a href="https://postmarkapp.com" target="_blank"><img src="https://postmarkapp.com/images/logo.svg" alt="Postmark Inbound" width="240" height="40"></a>

# Handle Postmark webhooks in a Laravel application

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

Postmark can send out several webhooks to *your* application when an event occurs.  
This way Postmark is able to immediately notify you when something new occurs.

This package can help you handle those webhooks.

## Installation

You can install the package via composer:

``` bash
composer require mvdnbrk/laravel-postmark-webhooks
```

The service provider will automatically register itself.

This package will log all incoming webhooks to the database by default.  
Run the migrations to create a `postmark_webhook_logs` table in the database:

``` bash
php artisan migrate
```
> If you want to disable database logging you can set `POSTMARK_WEBHOOKS_LOG_ENABLED=false` in your `.env` file. 

## Setup webhooks with Postmark

Visit the [servers](https://account.postmarkapp.com/servers) page on your [Postmark account](https://account.postmarkapp.com/).
Choose the server you want to setup webhooks for.  
Go to `settings` > `webhooks` > `add webbook`.  

This package will register a route where Postmark can post their webhooks to: `/api/webhooks/postmark`.

Fill in your webhook URL: `https://<your-domain.com>/api/webhooks/postmark`  
Pick the events Postmark should send to you and save the webhook.  
You are ready to receive webhook notifications from Postmark!

> You may change the `/api/webhooks/postmark` endpoint to anything you like.  
> You can do this by changing the `path` key in the `config/postmark-webooks.php` file.

## Protection of your webhook

This package protects your webhook automatically by only allowing requests from the [IP range](https://postmarkapp.com/support/article/800-ips-for-firewalls) that Postmark uses.

## Usage

Postmark can send out several event types by posting a webhook.  
You can find the [full list of webhooks](https://postmarkapp.com/developer/webhooks/webhooks-overview) in the Postmark documentation.

All webhook requests will be logged in the `postmark_webhook_logs` table.  
The table has a `payload` column where the entire payload of the incoming webhook is saved.  
The ID Postmark assigned to the original message will be saved in the `message_id` column,  
the event type will be stored in the `record_type` column and the email address as well in the `email` column.
> Note that event types will be converted to `snake_case`.  
For example `SpamComplaint` will be saved as `spam_complaint`.

### Events

Whenever a webhook call comes in, this package will fire a `PostmarkWebhookCalled` event.  
You may register an event listener in the `EventServiceProvider`:

```php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    PostmarkWebhookCalled::class => [
        YourListener::class,
    ],
];
```

Example of a listener:

```php
<?php

namespace App\Listeners;

use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;

class YourListener
{
    /**
     * Handle the event.
     *
     * @param  \Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled  $event
     * @return void
     */
    public function handle(PostmarkWebhookCalled $event)
    {
        // Do your work here.
        
        // You can access the payload here with: $event->payload.
        // The email address, message ID and record type are also available:
        // $event->email
        // $event->messageId
        // $event->recordType
    }
}

```

You may also register an event listener for a specific type of event:

```php
/**
 * The event listener mappings for the application.
 *
 * @var array
 */
protected $listen = [
    'webhook.postmark: spam_complaint' => [
        YourSpamComplaintListener::class,
    ],
];
```

Available events: `open`, `bounce`, `click`, `delivery`, `spam_complaint`.

### Advanced configuration

You may optionally publish the config file with:

```bash
php artisan vendor:publish --provider="Mvdnbrk\PostmarkWebhooks\PostmarkWebhooksServiceProvider" --tag="config"
```

Within the configuration file you may change the table name being used 
or the Eloquent model being used to save log records to the database.
> If you want to use your own model to save the logs to the database you should extend
the `Mvdnbrk\PostmarkWebhooks\PostmarkWebhook` class.

You can also exclude one or more event types from being logged to the database.  
Place the events you want to exclude under the `except` key:

```php
'log' => [
    ...
    'except' => [
        'open',
        ...
    ],
],
```

You can map the events fired by this package to your own event classes:

```php
'events' => [
    'spam_complaint' => App\Events\SpamComplaint,
    ...
],
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md)  for details.

## Security

If you discover any security related issues, please email mvdnbrk@gmail.com instead of using the issue tracker.

## Credits

- [Mark van den Broek][link-author]
- [All Contributors][link-contributors]

Inspired by [Laravel Stripe Webooks](https://github.com/spatie/laravel-stripe-webhooks) from [Spatie](https://spatie.be/).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/mvdnbrk/laravel-postmark-webhooks.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/mvdnbrk/laravel-postmark-webhooks/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/mvdnbrk/laravel-postmark-webhooks.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/mvdnbrk/laravel-postmark-webhooks.svg?style=flat-square
[ico-style-ci]: https://styleci.io/repos/149487979/shield?branch=master
[ico-downloads]: https://img.shields.io/packagist/dt/mvdnbrk/laravel-postmark-webhooks.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mvdnbrk/laravel-postmark-webhooks
[link-travis]: https://travis-ci.org/mvdnbrk/laravel-postmark-webhooks
[link-scrutinizer]: https://scrutinizer-ci.com/g/mvdnbrk/laravel-postmark-webhooks/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/mvdnbrk/laravel-postmark-webhooks
[link-style-ci]: https://styleci.io/repos/149487979
[link-downloads]: https://packagist.org/packages/mvdnbrk/laravel-postmark-webhooks
[link-author]: https://github.com/mvdnbrk
[link-contributors]: ../../contributors
