<?php

namespace Spatie\InteractiveSlackNotificationChannel\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackAttachment;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackAttachmentField;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage;

class InteractiveSlackChannel
{
    const API_ENDPOINT = 'https://slack.com/api/chat.postMessage';

    protected ?string $token = null;

    protected ?string $channel = null;

    public function send(mixed $notifiable, Notification $notification)
    {
        if (! $config = $notifiable->routeNotificationFor('interactiveSlack', $notification)) {
            return null;
        }

        $this->token = $config['token'];

        $this->channel = $config['channel'] ?? null;

        $payload = $this->buildJsonPayload($notification->toInteractiveSlack($notifiable));

        $response = Http::post(self::API_ENDPOINT, $payload);

        if (method_exists($notification, 'interactiveSlackResponse')) {
            return $notification->interactiveSlackResponse($response->json() ?? []);
        }

        return $response;
    }

    protected function buildJsonPayload(SlackMessage $message): array
    {
        $optionalFields = array_filter([
            'channel' => data_get($message, 'channel', $this->channel),
            'icon_emoji' => data_get($message, 'icon'),
            'icon_url' => data_get($message, 'image'),
            'link_names' => data_get($message, 'linkNames'),
            'unfurl_links' => data_get($message, 'unfurlLinks'),
            'unfurl_media' => data_get($message, 'unfurlMedia'),
            'username' => data_get($message, 'username'),
            'thread_ts' => data_get($message, 'threadTimestamp'),
            'reply_broadcast' => data_get($message, 'threadBroadcast'),
        ]);

        $payload = [
            'json' => array_merge([
                'text' => $message->content,
                'attachments' => $this->attachments($message),
            ], $optionalFields),
        ];


        $payload['headers'] = [
            'Content-type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];

        return array_merge($payload, $message->http);
    }

    protected function attachments(SlackMessage $message): array
    {
        return collect($message->attachments)
            ->map(function ($attachment) use ($message) {
                return array_filter([
                    'actions' => $attachment->actions,
                    'author_icon' => $attachment->authorIcon,
                    'author_link' => $attachment->authorLink,
                    'author_name' => $attachment->authorName,
                    'blocks' => $this->blocks($attachment),
                    'color' => $attachment->color ?: $message->color(),
                    'callback_id' => $attachment->callbackId,
                    'fallback' => $attachment->fallback,
                    'fields' => $this->fields($attachment),
                    'footer' => $attachment->footer,
                    'footer_icon' => $attachment->footerIcon,
                    'image_url' => $attachment->imageUrl,
                    'mrkdwn_in' => $attachment->markdown,
                    'pretext' => $attachment->pretext,
                    'text' => $attachment->content,
                    'thumb_url' => $attachment->thumbUrl,
                    'title' => $attachment->title,
                    'title_link' => $attachment->url,
                    'ts' => $attachment->timestamp,
                ]);
            })
            ->all();
    }

    /**
     * Format the attachment's fields.
     *
     * @param \Spatie\InteractiveSlackNotificationChannel\Messages\SlackAttachment $attachment
     *
     * @return array
     */
    protected function fields(SlackAttachment $attachment): array
    {
        return collect($attachment->fields)
            ->map(function ($value, $key) {
                return $value instanceof SlackAttachmentField
                    ? $value->toArray()
                    : ['title' => $key, 'value' => $value, 'short' => true];
            })
            ->values()
            ->all();
    }

    protected function blocks(SlackAttachment $attachment): array
    {
        return collect($attachment->blocks)
            ->map(fn ($value) => $value->toArray())
            ->values()
            ->all();
    }
}
