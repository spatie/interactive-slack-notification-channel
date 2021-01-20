<?php

namespace Spatie\SlackApiNotificationChannel;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class SlackApiNotificationChannelServiceProvider extends ServiceProvider
{
    public function register()
    {
        Notification::resolved(function (ChannelManager $service) {
            $service->extend('slack', function ($app) {
                return new Channels\SlackApiChannel();
            });
        });
    }
}
