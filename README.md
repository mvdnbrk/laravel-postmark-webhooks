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
$ composer require mvdnbrk/laravel-postmark-webhooks
```

The service provider will automatically register itself.

Run the migrations to create a `postmark_webhook_logs` table in the database:

``` bash
php artisan migrate
```

## Setup webhooks with Postmark

Visit the [servers](https://account.postmarkapp.com/servers) page on your [Postmark account](https://account.postmarkapp.com/).
Choose the server you want to setup webhooks for.  
Go to `settings` > `webhooks` > `add webbook`.  

This package will register a route where Postmark can post their webhooks to: `/api/webhooks/postmark`.

Fill in your webhook URL: `https://<your-domain.com>/api/webhooks/postmark`  
Pick the events Postmark should send to you and save the webhook.  
You are ready to receive webhook notifications from Postmark!

## Protection of your webhook

This package protects your webhook automatically by only allowing requests from the [IP range](https://postmarkapp.com/support/article/800-ips-for-firewalls) that Postmark uses.

## Usage

Postmark can send out several event types by posting a webhook.  
You can find the [full list of webhooks](https://postmarkapp.com/developer/webhooks/webhooks-overview) in the Postmark documentation.

All webhook requests will be logged in the `postmark_webhook_logs` table.  
The table has a payload column where the entire payload of the incoming webhook is saved.  
The ID Postmark assigned to the original message will be stored in the `message_id` column,  
the event type will be stored in the `record_type` column.
> Note that event types will be converted to `snake_case`. For example `SpamComplaint` will be stored as `spam_complaint`.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

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
