<?php

namespace Cardinal\Permissions\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{

    /**
     * Table
     *
     * @var string
     */
    public $table = 'roles';

    /**
     * Retrieves the roles of the given permission
     *
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

}