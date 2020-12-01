<?php

namespace Cardinal\Permissions;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{

    public function boot() {

        $this->loadMigrationsFrom(__DIR__ . '/migrations');

        Blade::directive('permission', function ($permission) {

            return "<?php if(auth()->check() && (auth()->user()->hasPermissionTo({$permission})) : ?>";

        });

        Blade::directive('role', function ($role) {

            return "<?php if(auth()->check() && (auth()->user()->hasRole({$role})) : ?>";

        });

        Blade::directive('endpermission', function () {

            return "<?php endif; ?>";

        });

        Blade::directive('endrole', function () {

            return "<?php endif; ?>";

        });

    }

}