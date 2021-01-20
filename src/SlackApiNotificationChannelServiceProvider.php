<?php

namespace Spatie\SlackApiNotificationChannel;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\ChannelManager;

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
