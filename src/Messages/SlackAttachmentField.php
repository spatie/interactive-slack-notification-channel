<?php

namespace Spatie\InteractiveSlackNotificationChannel\Messages;

class SlackAttachmentField
{
    protected ?string $title = null;

    protected ?string $content = null;

    protected bool $short = true;

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function long(): self
    {
        $this->short = false;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'value' => $this->content,
            'short' => $this->short,
        ];
    }
}
