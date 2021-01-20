# Send interactive Slack notifications in Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/slack-api-notification-channel.svg?style=flat-square)](https://packagist.org/packages/spatie/slack-api-notification-channel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/spatie/slack-api-notification-channel/run-tests?label=tests)](https://github.com/spatie/slack-api-notification-channel/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/slack-api-notification-channel.svg?style=flat-square)](https://packagist.org/packages/spatie/slack-api-notification-channel)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/package-slack-api-notification-channel-laravel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/package-slack-api-notification-channel-laravel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/slack-api-notification-channel
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="Spatie\SlackApiNotificationChannel\SlackApiNotificationChannelServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Spatie\SlackApiNotificationChannel\SlackApiNotificationChannelServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$slack-api-notification-channel = new Spatie\SlackApiNotificationChannel();
echo $slack-api-notification-channel->echoPhrase('Hello, Spatie!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
