<?php

namespace Farzai\ModelSettings\Tests;

use Farzai\ModelSettings\ModelSettingServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        //
    }

    protected function getPackageProviders($app)
    {
        return [
            ModelSettingServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $this->migrateFromFile(__DIR__.'/../database/migrations/create_model-settings_table.php.stub');
        $this->migrateFromFile(__DIR__.'/migrations/create_posts_table.php.stub');
    }

    protected function migrateFromFile(string $path): void
    {
        if (! file_exists($path)) {
            throw new \InvalidArgumentException("File does not exist at path {$path}");
        }

        $migration = include $path;
        $migration->up();
    }
}
