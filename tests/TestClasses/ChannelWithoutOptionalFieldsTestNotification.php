<?php

namespace Spatie\SlackApiNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notification;
use Spatie\SlackApiNotificationChannel\Messages\SlackMessage;

class ChannelWithoutOptionalFieldsTestNotification extends Notification
{
    public function toSlackApi($notifiable)
    {
        return (new SlackMessage)
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
