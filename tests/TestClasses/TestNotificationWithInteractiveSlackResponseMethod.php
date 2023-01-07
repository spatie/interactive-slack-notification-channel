<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests\TestClasses;

use Illuminate\Notifications\Notification;
use Spatie\InteractiveSlackNotificationChannel\Messages\SlackMessage;

class TestNotificationWithInteractiveSlackResponseMethod extends TestNotification
{
    public function interactiveSlackResponse()
    {

    }
}
