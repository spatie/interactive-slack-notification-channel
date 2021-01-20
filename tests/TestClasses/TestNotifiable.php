<?php

namespace Spatie\SlackApiNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForSlackApi()
    {
        return [
            'token' => 'xoxp-token',
            'channel' => '#general',
        ];
    }
}
