<?php

namespace Spatie\InteractiveSlackNotificationChannel\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\InteractiveSlackNotificationChannel\InteractiveSlackNotificationChannelServiceProvider;

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
            InteractiveSlackNotificationChannelServiceProvider::class,
        ];
    }
}
