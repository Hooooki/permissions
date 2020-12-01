<?php


namespace Cardinal\Permissions\Traits;


use Cardinal\Permissions\Models\Permission;
use Cardinal\Permissions\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermission
{

    /**
     * User roles
     *
     * @return BelongsToMany
     */
    protected function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * @param mixed ...$permissions
     * @return $this
     */
    protected function givePermissionsTo(...$permissions) : self
    {
        $permissions = $this->getAllPermissions($permissions);

        if ($permissions === null) {
            return $this;
        }
        $this->permissions()->saveMany($permissions);
        return $this;
    }

    protected function withdrawPermissionsTo(...$permissions)
    {
        $permissions = $this->getAllPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }

    protected function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();
        return $this->givePermissionsTo($permissions);
    }

    protected function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    protected function hasPermissionThroughRole($permission)
    {

        foreach ($this->roles as $role) {

            if ($role->permissions->where('slug', $permission->slug)->count() > 0) {

                return true;

            }

        }

        return false;
    }

    protected function hasPermission($permission)
    {
        return (bool)$this->permissions->where('slug', $permission->slug)->count();
    }

    protected function getAllPermissions(array $permissions)
    {
        return Permission::whereIn('slug', $permissions)->get();
    }

    protected function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    protected function higherRole()
    {
        $higher = $this->roles()->first();

        foreach ($this->roles as $role) {
            $higher = ($role->power >= $higher->power) ? $role->power : $higher->power;
        }

        return $higher;

    }
}