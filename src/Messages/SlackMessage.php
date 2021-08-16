<?php

namespace Spatie\InteractiveSlackNotificationChannel\Messages;

use Closure;
use DateInterval;
use DateTimeInterface;

class SlackMessage
{
    public string $level = 'info';

    public ?string $username = null;

    public ?string $icon = null;

    public ?string $image = null;

    public ?string $channel = null;

    public ?string $content = null;

    public bool $linkNames = false;

    public bool $unfurlLinks = false;

    public bool $unfurlMedia = false;

    public array $attachments = [];

    public array $http = [];

    public string $threadTimestamp = '';

    public bool $threadBroadcast = false;

    public function info(): self
    {
        $this->level = 'info';

        return $this;
    }

    public function success(): self
    {
        $this->level = 'success';

        return $this;
    }

    public function warning(): self
    {
        $this->level = 'warning';

        return $this;
    }

    public function error(): self
    {
        $this->level = 'error';

        return $this;
    }

    public function from(string $username, ?string $icon = null): self
    {
        $this->username = $username;

        if (! is_null($icon)) {
            $this->icon = $icon;
        }

        return $this;
    }

    public function image(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function to(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function attachment(Closure $callback): self
    {
        $this->attachments[] = $attachment = new SlackAttachment();

        $callback($attachment);

        return $this;
    }

    /**
     * Get the color for the message.
     *
     * @return string|null
     */
    public function color()
    {
        $colorNames = [
            'success' => 'good',
            'error' => 'danger',
            'warning' => 'warning',
        ];

        return $colorNames[$this->level] ?? null;
    }

    public function linkNames(): self
    {
        $this->linkNames = true;

        return $this;
    }

    public function unfurlLinks(bool $unfurl): self
    {
        $this->unfurlLinks = $unfurl;

        return $this;
    }

    public function unfurlMedia(bool $unfurl): self
    {
        $this->unfurlMedia = $unfurl;

        return $this;
    }

    public function http(array $options): self
    {
        $this->http = $options;

        return $this;
    }

    public function threadTimestamp(string $threadTimestamp): self
    {
        $this->threadTimestamp = $threadTimestamp;

        return $this;
    }

    public function threadBroadcast(bool $threadBroadcast = true)
    {
        $this->threadBroadcast = $threadBroadcast;

        return $this;
    }
}
