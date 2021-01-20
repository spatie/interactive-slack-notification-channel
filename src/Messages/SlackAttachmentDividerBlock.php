<?php

namespace Spatie\SlackApiNotificationChannel\Messages;

class SlackAttachmentDividerBlock
{
    public function toArray(): array
    {
        return [
            'type' => 'divider',
        ];
    }
}
