<?php

namespace Spatie\InteractiveSlackNotificationChannel;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class InteractiveSlackNotificationChannelServiceProvider extends ServiceProvider
{
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('slack', function ($app) {
                return new Channels\InteractiveSlackChannel();
            });
        });
    }
}
