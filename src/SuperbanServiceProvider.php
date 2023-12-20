<?php

namespace Zeevx\Superban;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class SuperbanServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('superban')
            ->hasConfigFile('superban');
    }
}
