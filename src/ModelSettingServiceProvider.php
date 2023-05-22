<?php

namespace Farzai\ModelSettings;

use Farzai\ModelSettings\Contracts\Setting as SettingContract;
use Farzai\ModelSettings\Storage\EloquentStorageRepository;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ModelSettingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-model-settings')
            ->hasConfigFile()
            ->hasMigration('create_model_settings_table');

        $this->app->when(EloquentStorageRepository::class)
            ->needs('$model')
            ->give(function () {
                return config('model-settings.model');
            });

        $this->app->bind(SettingContract::class, EloquentStorageRepository::class);
    }
}
