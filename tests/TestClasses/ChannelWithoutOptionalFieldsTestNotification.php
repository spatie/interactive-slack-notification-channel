<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notification;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage;

class ChannelWithoutOptionalFieldsTestNotification extends Notification
{
    public function toInteractiveSlack($notifiable)
    {
        return (new SlackMessage())
            ->content('Content')
            ->attachment(function ($attachment) {
                $attachment->title('Laravel', 'https://laravel.com')
                    ->content('Attachment Content')
                    ->fields([
                        'Project' => 'Laravel',
                    ]);
            });
    }
}
