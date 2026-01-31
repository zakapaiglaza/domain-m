<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Role extends SpatieRole
{
    use CrudTrait;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            \Spatie\Permission\Models\Permission::class,
            'role_has_permissions',
            'role_id',
            'permission_id'
        );
    }
}
