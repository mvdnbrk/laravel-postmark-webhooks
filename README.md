<p align="center"><a href="https://postmarkapp.com" target="_blank"><img src="https://postmarkapp.com/images/logo.svg" alt="Postmark" width="240" height="40"></a>

# Handle Postmark webhooks in a Laravel application

![PHP version][ico-php-version]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Tests][ico-tests]][link-tests]
[![StyleCI][ico-style-ci]][link-style-ci]
[![Total Downloads][ico-downloads]][link-downloads]

Postmark can send out several webhooks to *your* application when an event occurs.  
This way Postmark is able to immediately notify you when something new occurs.

This package can help you handle those webhooks.

## Requirements

- PHP 8.2 or higher
- Laravel 12 or 13 (Laravel 13 requires PHP 8.3 or higher)

## Installation

You can install the package via composer:

```bash
composer require mvdnbrk/laravel-postmark-webhooks
```

This package will log all incoming webhooks to the database by default.  
Run the migrations to create a `postmark_webhook_logs` table in the database:

```bash
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
> You can do this by changing the `path` key in the `config/postmark-webhooks.php` file.

## Protection of your webhook

This package protects your webhook automatically by only allowing requests from the [IP range](https://postmarkapp.com/support/article/800-ips-for-firewalls#webhooks) that Postmark uses.

When your app runs behind a proxy or load balancer (Cloudflare, ngrok, a load balancer), Laravel sees the proxy's IP address instead of Postmark's, and every webhook is rejected with a `401`. [Configure trusted proxies](https://laravel.com/docs/requests#configuring-trusted-proxies) so Laravel reads the real client IP, for example in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->trustProxies(at: '*');
})
```

Only trust all proxies (`*`) when your app can't be reached except through the proxy.

The IP check is skipped when `APP_ENV` is `local`, so you can test webhooks with a tunnel such as ngrok.

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
Laravel discovers listeners in `app/Listeners` automatically by the event type-hint of their `handle` method.  
You may also register a listener yourself in the `boot` method of your `AppServiceProvider`:

```php
use Illuminate\Support\Facades\Event;
use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;

Event::listen(PostmarkWebhookCalled::class, YourListener::class);
```

Example of a listener:

```php
<?php

namespace App\Listeners;

use Mvdnbrk\PostmarkWebhooks\Events\PostmarkWebhookCalled;

class YourListener
{
    public function handle(PostmarkWebhookCalled $event): void
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
Event::listen('webhook.postmark: spam_complaint', YourSpamComplaintListener::class);
```

The listener receives the `PostmarkWebhookCalled` event as well.
> A listener in `app/Listeners` with a `PostmarkWebhookCalled` type-hint is also discovered for every webhook.  
> Keep listeners for a specific type outside `app/Listeners` to avoid running them twice.

Available events: `open`, `bounce`, `click`, `delivery`, `spam_complaint`, `subscription_change`.

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
    'spam_complaint' => App\Events\SpamComplaint::class,
    ...
],
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mark van den Broek][link-author]
- [All Contributors][link-contributors]

Inspired by [Laravel Stripe Webhooks](https://github.com/spatie/laravel-stripe-webhooks) from [Spatie](https://spatie.be/).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-php-version]: https://img.shields.io/packagist/php-v/mvdnbrk/laravel-postmark-webhooks?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/mvdnbrk/laravel-postmark-webhooks.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-tests]: https://img.shields.io/github/actions/workflow/status/mvdnbrk/laravel-postmark-webhooks/tests.yml?branch=main&label=tests&style=flat-square
[ico-style-ci]: https://styleci.io/repos/149487979/shield?branch=main
[ico-downloads]: https://img.shields.io/packagist/dt/mvdnbrk/laravel-postmark-webhooks.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/mvdnbrk/laravel-postmark-webhooks
[link-tests]: https://github.com/mvdnbrk/laravel-postmark-webhooks/actions?query=workflow%3Atests
[link-style-ci]: https://styleci.io/repos/149487979
[link-downloads]: https://packagist.org/packages/mvdnbrk/laravel-postmark-webhooks
[link-author]: https://github.com/mvdnbrk
[link-contributors]: ../../contributors
