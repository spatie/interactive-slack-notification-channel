<?php

namespace Spatie\InteractiveSlackNotificationChannel\Messages;

class SlackAttachmentDividerBlock
{
    public function toArray(): array
    {
        return [
            'type' => 'divider',
        ];
    }
}
