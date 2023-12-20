<?php

namespace Zeevx\Superban;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Zeevx\Superban\Commands\SuperbanCommand;

class SuperbanServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('superban')
            ->hasConfigFile();
    }
}
