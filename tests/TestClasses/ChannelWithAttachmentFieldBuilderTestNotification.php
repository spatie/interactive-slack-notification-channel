<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notification;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage;

class ChannelWithAttachmentFieldBuilderTestNotification extends Notification
{
    public function toInteractiveSlack($notifiable)
    {
        return (new SlackMessage)
            ->content('Content')
            ->attachment(function ($attachment) {
                $attachment->title('Laravel', 'https://laravel.com')
                    ->content('Attachment Content')
                    ->field('Project', 'Laravel')
                    ->field(function ($attachmentField) {
                        $attachmentField
                            ->title('Special powers')
                            ->content('Zonda')
                            ->long();
                    });
            });
    }
}
