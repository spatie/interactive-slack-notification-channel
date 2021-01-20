<?php

namespace Spatie\SlackApiNotificationChannel\Messages;

use Illuminate\Contracts\Support\Arrayable;

class SlackAttachmentBlock implements Arrayable
{

    public ?string $type = null;

    public ?string $text = null;

    public ?string $id = null;

    public array $fields = [];

    public array $accessory = [];

    public ?string $imageUrl = null;

    public ?string $altText = null;

    public string $title;

    public array $elements = [];

    public function type(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function id(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function fields(array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    public function accessory(array $accessory): self
    {
        $this->accessory = $accessory;

        return $this;
    }

    public function imageUrl(string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function altText(string $altText): self
    {
        $this->altText = $altText;

        return $this;
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function elements(array $elements): self
    {
        $this->elements = $elements;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'text' => $this->text,
            'block_id' => $this->id,
            'fields' => $this->fields,
            'accessory' => $this->accessory,
            'image_url' => $this->imageUrl,
            'alt_text' => $this->altText,
            'title' => $this->title,
            'elements' => $this->elements,
        ]);
    }
}
