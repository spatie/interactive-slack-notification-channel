<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notification;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage;

class NotificationWithDefaultChannel extends Notification
{
    public function toInteractiveSlack($notifiable)
    {
        return (new SlackMessage)
            ->from('Ghostbot')
            ->image('http://example.com/image.png')
            ->content('Content')
            ->attachment(function ($attachment) {
                $attachment->title('Laravel', 'https://laravel.com')
                    ->content('Attachment Content')
                    ->fallback('Attachment Fallback')
                    ->fields([
                        'Project' => 'Laravel',
                    ])
                    ->footer('Laravel')
                    ->footerIcon('https://laravel.com/fake.png')
                    ->markdown(['text'])
                    ->timestamp(now()->timestamp);
            });
    }
}
