<?php

namespace Spatie\SlackApiNotificationChannel\Messages;

use Closure;
use Illuminate\Support\InteractsWithTime;

class SlackAttachment
{
    use InteractsWithTime;

    /**
     * The attachment's title.
     *
     * @var string
     */
    public string $title;

    /**
     * The attachment's URL.
     *
     * @var string
     */
    public $url;

    /**
     * The attachment's pretext.
     *
     * @var string
     */
    public $pretext;

    /**
     * The attachment's text content.
     *
     * @var string
     */
    public $content;

    /**
     * A plain-text summary of the attachment.
     *
     * @var string
     */
    public $fallback;

    /**
     * The attachment's color.
     *
     * @var string
     */
    public $color;

    /**
     * The attachment's callback id.
     *
     * @var string
     */
    public $callbackId;

    /**
     * The attachment's fields.
     *
     * @var array
     */
    public $fields;

    /**
     * The attachment's blocks.
     *
     * @var array
     */
    public $blocks;

    /**
     * The fields containing markdown.
     *
     * @var array
     */
    public $markdown;

    /**
     * The attachment's image url.
     *
     * @var string
     */
    public $imageUrl;

    /**
     * The attachment's thumb url.
     *
     * @var string
     */
    public $thumbUrl;

    /**
     * The attachment's actions.
     *
     * @var array
     */
    public $actions = [];

    /**
     * The attachment author's name.
     *
     * @var string
     */
    public $authorName;

    /**
     * The attachment author's link.
     *
     * @var string
     */
    public $authorLink;

    /**
     * The attachment author's icon.
     *
     * @var string
     */
    public $authorIcon;

    /**
     * The attachment's footer.
     *
     * @var string
     */
    public $footer;

    /**
     * The attachment's footer icon.
     *
     * @var string
     */
    public $footerIcon;

    /**
     * The attachment's timestamp.
     *
     * @var int
     */
    public $timestamp;

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

    public function field(Closure|string $title, string $content = ''): self
    {
        if (is_callable($title)) {
            $callback = $title;

            $callback($attachmentField = new SlackAttachmentField);

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

    public function action(string $title,string  $url, string $style = ''): self
    {
        $this->actions[] = [
            'type' => 'button',
            'text' => $title,
            'url' => $url,
            'style' => $style,
        ];

        return $this;
    }

    public function button(string $title,string  $name, string $value, string $style = ''): self
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

    public function timestamp(\DateTimeInterface|\DateInterval|int $timestamp): self
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
