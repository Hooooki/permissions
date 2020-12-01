<?php

namespace Cardinal\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{

    public function boot() {

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

    }

}