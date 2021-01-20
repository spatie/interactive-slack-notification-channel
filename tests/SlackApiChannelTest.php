<?php

namespace Spatie\SlackApiNotificationChannel\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notification;
use Spatie\SlackApiNotificationChannel\Channels\SlackApiChannel;
use Spatie\SlackApiNotificationChannel\Tests\TestClasses\TestNotifiable;
use Spatie\SlackApiNotificationChannel\Tests\TestClasses\TestNotification;
use Spatie\SlackApiNotificationChannel\Tests\TestClasses\NotificationWithDefaultChannel;
use Spatie\SlackApiNotificationChannel\Tests\TestClasses\NotificationWithImageIcon;
use Spatie\SlackApiNotificationChannel\Tests\TestClasses\ChannelWithAttachmentFieldBuilderTestNotification;
use Spatie\SlackApiNotificationChannel\Tests\TestClasses\ChannelWithoutOptionalFieldsTestNotification;

class SlackApiChannelTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider payloadDataProvider
     */
    public function it_can_send_the_correct_payload_to_slack(Notification $notification, array $payload)
    {
        Http::fake(['*' => Http::response(json_encode($payload))]);
        /*
        $this->guzzleHttp->shouldReceive('post')->andReturnUsing(function ($argUrl, $argPayload) use ($payload) {
            $this->assertEquals($argUrl, 'https://slack.com/api/chat.postMessage');
            $this->assertEquals($argPayload, $payload);

            return new Response(200, [], json_encode($payload));
        });
        */

        (new SlackApiChannel())->send(new TestNotifiable, $notification);

        Http::assertSent(function(Request $request) use ($payload) {
            $this->assertEquals('POST', $request->method());
            $this->assertEquals('https://slack.com/api/chat.postMessage', $request->url());

            $requestJson = json_decode($request->body(), true);
            $this->assertEquals($payload, $requestJson);

            return true;
        });
    }

    public function payloadDataProvider(): array
    {
        return [
            'payloadWithIcon' => $this->getPayloadWithIcon(),
            'payloadWithImageIcon' => $this->getPayloadWithImageIcon(),
            'payloadWithDefaultChannel' => $this->getPayloadWithDefaultChannel(),
            'payloadWithoutOptionalFields' => $this->getPayloadWithoutOptionalFields(),
            'payloadWithAttachmentFieldBuilder' => $this->getPayloadWithAttachmentFieldBuilder(),
        ];
    }

    protected function getPayloadWithIcon()
    {
        return [
            new TestNotification,
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
                            'ts' => 1234567890,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getPayloadWithImageIcon(): array
    {
        return [
            new NotificationWithImageIcon,
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
                            'ts' => 1234567890,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getPayloadWithDefaultChannel(): array
    {
        return [
            new NotificationWithDefaultChannel,
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
                            'ts' => 1234567890,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getPayloadWithoutOptionalFields(): array
    {
        return [
            new ChannelWithoutOptionalFieldsTestNotification,
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
                    'channel' => '#general'
                ],
            ],
        ];
    }

    protected function getPayloadWithAttachmentFieldBuilder(): array
    {
        return [
            new ChannelWithAttachmentFieldBuilderTestNotification,
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
                    'channel' => '#general'
                ],
            ],
        ];
    }
}
