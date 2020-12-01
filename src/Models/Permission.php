<?php

namespace Cardinal\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{

    /**
     * Table
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * Retrieves permissions for a role
     *
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }

}