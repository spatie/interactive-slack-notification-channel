<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notifiable;

class TestNotifiable
{
    use Notifiable;

    public function routeNotificationForInteractiveSlack()
    {
        return [
            'token' => 'xoxp-token',
            'channel' => '#general',
        ];
    }
}
