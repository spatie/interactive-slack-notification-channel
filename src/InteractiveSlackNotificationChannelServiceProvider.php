<?php

namespace Spatie\InteractiveSlackNotificationChannel;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Spatie\InteractiveSlackNotificationChannel\Channels\InteractiveSlackChannel;

class InteractiveSlackNotificationChannelServiceProvider extends ServiceProvider
{
    public function register()
    {
        Notification::extend('interactiveSlack', static function (Container $app) {
            return $app->make(InteractiveSlackChannel::class);
        });
    }
}
