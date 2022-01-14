<?php

namespace Spatie\InteractiveSlackNotificationChannel\Messages;

use Closure;
use Illuminate\Support\InteractsWithTime;

class SlackAttachment
{
    use InteractsWithTime;

    public ?string $title = null;

    public ?string $url = null;

    public ?string $pretext = null;

    public ?string $content = null;

    public ?string $fallback = null;

    public ?string $color = null;

    public ?string $callbackId = null;

    public array $fields = [];

    public array $blocks = [];

    public array $markdown = [];

    public ?string $imageUrl = null;

    public ?string $thumbUrl = null;

    public array $actions = [];

    public ?string $authorName = null;

    public ?string $authorLink = null;

    public ?string $authorIcon = null;

    public ?string $footer = null;

    public ?string $footerIcon = null;

    public ?int $timestamp = null;

    public function title(string $title, string $url = null): self
    {
        $this->title = $title;

        $this->url = $url;

        return $this;
    }

    public function pretext(string $pretext): self
    {
        $this->pretext = $pretext;

        return $this;
    }

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function fallback(string $fallback): self
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function callbackId(string $callbackId): self
    {
        $this->callbackId = $callbackId;

        return $this;
    }

    public function field(Closure | string $title, string $content = ''): self
    {
        if (is_callable($title)) {
            $callback = $title;

            $callback($attachmentField = new SlackAttachmentField());

            $this->fields[] = $attachmentField;

            return $this;
        }

        $this->fields[$title] = $content;

        return $this;
    }

    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function markdown(array $fields): self
    {
        $this->markdown = $fields;

        return $this;
    }

    public function image(string $url): self
    {
        $this->imageUrl = $url;

        return $this;
    }

    public function thumb(string $url): self
    {
        $this->thumbUrl = $url;

        return $this;
    }

    public function action(string $title, string  $url, string $style = ''): self
    {
        $this->actions[] = [
            'type' => 'button',
            'text' => $title,
            'url' => $url,
            'style' => $style,
        ];

        return $this;
    }

    public function button(string $title, string  $name, string $value, string $style = ''): self
    {
        $this->actions[] = [
            'type' => 'button',
            'text' => $title,
            'name' => $name,
            'value' => $value,
            'style' => $style,
        ];

        return $this;
    }

    public function select(string $title, string $name, array $options, string $style = ''): self
    {
        $this->actions[] = [
            'type' => 'select',
            'text' => $title,
            'name' => $name,
            'options' => $options,
            'style' => $style,
        ];

        return $this;
    }

    public function author(string $name, string $link = null, string $icon = null): self
    {
        $this->authorName = $name;

        $this->authorLink = $link;

        $this->authorIcon = $icon;

        return $this;
    }

    public function footer(string $footer): self
    {
        $this->footer = $footer;

        return $this;
    }

    public function footerIcon(string $icon): self
    {
        $this->footerIcon = $icon;

        return $this;
    }

    public function timestamp(\DateTimeInterface | \DateInterval | int $timestamp): self
    {
        $this->timestamp = $this->availableAt($timestamp);

        return $this;
    }

    public function block(Closure $callback): self
    {
        $this->blocks[] = $block = new SlackAttachmentBlock();

        $callback($block);

        return $this;
    }

    public function dividerBlock(): self
    {
        $this->blocks[] = new SlackAttachmentDividerBlock();

        return $this;
    }
}
