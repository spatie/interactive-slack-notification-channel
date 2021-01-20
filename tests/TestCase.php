<?php

namespace Spatie\SlackApiNotificationChannel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\SlackApiNotificationChannel\SlackApiNotificationChannelServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        ray()->newScreen('Test');

        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            SlackApiNotificationChannelServiceProvider::class,
        ];
    }
}
