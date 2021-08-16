# Send interactive Slack notifications in Laravel apps

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/interactive-slack-notification-channel.svg?style=flat-square)](https://packagist.org/packages/spatie/interactive-slack-notification-channel)
![Tests](https://github.com/spatie/interactive-slack-notification-channel/workflows/Tests/badge.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/interactive-slack-notification-channel.svg?style=flat-square)](https://packagist.org/packages/spatie/interactive-slack-notification-channel)

This package allows you to send interactive Slack notifications. Here's how such a notification could look like

<img src="https://github.com/spatie/interactive-slack-notification-channel/blob/master/docs/images/notification.png" width="650px" />

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/interactive-slack-notification-channel.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/interactive-slack-notification-channel)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can
support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.
You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards
on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation

You can install the package via composer:

```bash
composer require spatie/interactive-slack-notification-channel
```

## Usage

In your `Notifiable` classes you should add a method named `routeNotificationForSlackApi` that returns an array with the
API token, an optionally the channel name

```php
public function routeNotificationForInteractiveSlack()
{
    return [
        'token' => 'xoxp-slack-token',
        'channel' => '#general' // this is optional
    ];
}
```

### Replying to message threads

Let's assume you want your application to send a Slack notification when an order gets placed. You also want any
subsequent messages about the order be place in the same thread.

Using the SlackApi channels you can retrieve the API response from Slack's `chat.postMessage` method. With this response
you could post messages on other events that happen on the order, such as order paid, shipped, closed, etc.

Here's an example:

```php
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage

public function toInteractiveSlack($notifiable)
{
    return (new SlackMessage)->content('A new order has been placed');
}

public function interactiveSlackResponse(array $response)
{    
    $this->order->update(['slack_thread_ts' => $response['ts']]);
}
```

In your order paid event you can have

```php
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackAttachment;

public function toInteractiveSlack($notifiable)
{
    $order = $this->order;

    return (new SlackMessage)
        ->success()
        ->content('Order paid')
        ->threadTimestamp($order->slack_thread_ts)
        ->attachment(function(SlackAttachment $attachment) use ($order) {
           $attachment
                ->title("Order $order->reference has been paid for.")
                ->content('Should now be processed.')
                ->action('View Order', route('orders', $order->reference));
       });
}
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

Some parts of the code and readme are based on [this package](https://github.com/beyondcode/slack-notification-channel).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
