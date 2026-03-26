<?php

use Illuminate\Http\Client\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Spatie\InteractiveSlackNotificationChannel\Channels\InteractiveSlackChannel;
use Spatie\InteractiveSlackNotificationChannel\Exceptions\SlackRespondedWithError;
use Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses\ChannelWithAttachmentFieldBuilderTestNotification;
use Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses\ChannelWithoutOptionalFieldsTestNotification;
use Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses\NotificationWithDefaultChannel;
use Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses\NotificationWithImageIcon;
use Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses\TestNotifiable;
use Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses\TestNotification;
use Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses\TestNotificationWithInteractiveSlackResponseMethod;

it('can send the correct payload to slack', function (Notification $notification, array $payload) {
    Http::fake(['*' => Http::response(json_encode(['ok' => true]))]);

    (new InteractiveSlackChannel())->send(new TestNotifiable(), $notification);

    Http::assertSent(function (Request $request) use ($payload) {
        expect($request->method())->toBe('POST')
            ->and($request->url())->toBe('https://slack.com/api/chat.postMessage');

        $requestJson = json_decode($request->body(), true);

        expect($requestJson)->toEqualCanonicalizing($payload['json']);

        return true;
    });
})->with('payloads');

it('will throw an exception if slack does not respond ok and the notification has the correct method', function () {
    Http::fake(['*' => Http::response(json_encode(['ok' => false]))]);

    (new InteractiveSlackChannel())->send(new TestNotifiable(), new TestNotificationWithInteractiveSlackResponseMethod());
})->throws(SlackRespondedWithError::class);

dataset('payloads', [
    'payloadWithIcon' => [
        fn () => new TestNotification(),
        [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer xoxp-token',
            ],
            'json' => [
                'username' => 'Ghostbot',
                'icon_emoji' => ':ghost:',
                'channel' => '#ghost-talk',
                'text' => 'Content',
                'attachments' => [
                    [
                        'title' => 'Laravel',
                        'title_link' => 'https://laravel.com',
                        'text' => 'Attachment Content',
                        'fallback' => 'Attachment Fallback',
                        'fields' => [
                            [
                                'title' => 'Project',
                                'value' => 'Laravel',
                                'short' => true,
                            ],
                        ],
                        'mrkdwn_in' => ['text'],
                        'footer' => 'Laravel',
                        'footer_icon' => 'https://laravel.com/fake.png',
                        'author_name' => 'Author',
                        'author_link' => 'https://laravel.com/fake_author',
                        'author_icon' => 'https://laravel.com/fake_author.png',
                        'ts' => 3155673600,
                    ],
                ],
            ],
        ],
    ],
    'payloadWithImageIcon' => [
        fn () => new NotificationWithImageIcon(),
        [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer xoxp-token',
            ],
            'json' => [
                'username' => 'Ghostbot',
                'icon_url' => 'http://example.com/image.png',
                'channel' => '#ghost-talk',
                'text' => 'Content',
                'attachments' => [
                    [
                        'title' => 'Laravel',
                        'title_link' => 'https://laravel.com',
                        'text' => 'Attachment Content',
                        'fallback' => 'Attachment Fallback',
                        'fields' => [
                            [
                                'title' => 'Project',
                                'value' => 'Laravel',
                                'short' => true,
                            ],
                        ],
                        'mrkdwn_in' => ['text'],
                        'footer' => 'Laravel',
                        'footer_icon' => 'https://laravel.com/fake.png',
                        'ts' => 3155673600,
                    ],
                ],
            ],
        ],
    ],
    'payloadWithDefaultChannel' => [
        fn () => new NotificationWithDefaultChannel(),
        [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer xoxp-token',
            ],
            'json' => [
                'username' => 'Ghostbot',
                'icon_url' => 'http://example.com/image.png',
                'channel' => '#general',
                'text' => 'Content',
                'attachments' => [
                    [
                        'title' => 'Laravel',
                        'title_link' => 'https://laravel.com',
                        'text' => 'Attachment Content',
                        'fallback' => 'Attachment Fallback',
                        'fields' => [
                            [
                                'title' => 'Project',
                                'value' => 'Laravel',
                                'short' => true,
                            ],
                        ],
                        'mrkdwn_in' => ['text'],
                        'footer' => 'Laravel',
                        'footer_icon' => 'https://laravel.com/fake.png',
                        'ts' => 3155673600,
                    ],
                ],
            ],
        ],
    ],
    'payloadWithoutOptionalFields' => [
        fn () => new ChannelWithoutOptionalFieldsTestNotification(),
        [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer xoxp-token',
            ],
            'json' => [
                'text' => 'Content',
                'attachments' => [
                    [
                        'title' => 'Laravel',
                        'title_link' => 'https://laravel.com',
                        'text' => 'Attachment Content',
                        'fields' => [
                            [
                                'title' => 'Project',
                                'value' => 'Laravel',
                                'short' => true,
                            ],
                        ],
                    ],
                ],
                'channel' => '#general',
            ],
        ],
    ],
    'payloadWithAttachmentFieldBuilder' => [
        fn () => new ChannelWithAttachmentFieldBuilderTestNotification(),
        [
            'headers' => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer xoxp-token',
            ],
            'json' => [
                'text' => 'Content',
                'attachments' => [
                    [
                        'title' => 'Laravel',
                        'text' => 'Attachment Content',
                        'title_link' => 'https://laravel.com',
                        'fields' => [
                            [
                                'title' => 'Project',
                                'value' => 'Laravel',
                                'short' => true,
                            ],
                            [
                                'title' => 'Special powers',
                                'value' => 'Zonda',
                                'short' => false,
                            ],
                        ],
                    ],
                ],
                'channel' => '#general',
            ],
        ],
    ],
]);
