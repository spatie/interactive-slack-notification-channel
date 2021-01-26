<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\InteractiveSlackNotificationChannel\InteractiveSlackNotificationChannelServiceProvider;
use Spatie\TestTime\TestTime;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        ray()->newScreen('Test');

        TestTime::freezeAtSecond('Y-m-d H:i:s', '2020-01-01 00:00:00');

        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            InteractiveSlackNotificationChannelServiceProvider::class,
        ];
    }
}
