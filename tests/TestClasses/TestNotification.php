<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notification;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage;

class TestNotification extends Notification
{
    public function toInteractiveSlack($notifiable)
    {
        return (new SlackMessage)
            ->from('Ghostbot', ':ghost:')
            ->to('#ghost-talk')
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
                    ->author('Author', 'https://laravel.com/fake_author', 'https://laravel.com/fake_author.png')
                    ->timestamp(now()->timestamp);
            });
    }
}
