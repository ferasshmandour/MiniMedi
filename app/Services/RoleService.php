<?php

namespace App\Services;

use Spatie\Permission\Models\Role;

class RoleService
{
    /**
     * List all roles
     */
    public function getAllRoles()
    {
        return Role::with('permissions')->get();
    }

    /**
     * Store new role
     */
    public function store(array $data)
    {
        $role = Role::create([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        if (isset($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    /**
     * Get role by ID
     */
    public function getRole(Role $role)
    {
        return $role->load('permissions', 'users');
    }

    /**
     * Delete role
     */
    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
    }
}
