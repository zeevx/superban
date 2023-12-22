<?php

namespace Zeevx\Superban\Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Orchestra\Testbench\TestCase as Orchestra;
use Zeevx\Superban\SuperbanServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('cache:clear');
        Mail::fake();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('superban.email_address', 'example@mail.com');
        $app['config']->set('superban.cache', 'array');
    }

    protected function getPackageProviders($app)
    {
        return [
            SuperbanServiceProvider::class,
        ];
    }
}
