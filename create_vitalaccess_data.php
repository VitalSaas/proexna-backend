<?php

echo "Creating VitalAccess RBAC data...\n";

try {
    // Crear rol admin
    $admin = Kaely\Access\Models\Role::firstOrCreate([
        'name' => 'admin'
    ], [
        'slug' => 'admin',
        'description' => 'Administrator Role',
        'level' => 100,
        'is_active' => true
    ]);
    echo "✅ Admin role: " . $admin->name . "\n";

    // Crear rol user
    $user = Kaely\Access\Models\Role::firstOrCreate([
        'name' => 'user'
    ], [
        'slug' => 'user',
        'description' => 'User Role',
        'level' => 20,
        'is_active' => true
    ]);
    echo "✅ User role: " . $user->name . "\n";

    // Crear permisos
    $userView = Kaely\Access\Models\Permission::firstOrCreate([
        'name' => 'users.view'
    ], [
        'slug' => 'users.view',
        'group' => 'users',
        'action' => 'view',
        'description' => 'View users',
        'is_active' => true
    ]);
    echo "✅ Permission: " . $userView->name . "\n";

    $userCreate = Kaely\Access\Models\Permission::firstOrCreate([
        'name' => 'users.create'
    ], [
        'slug' => 'users.create',
        'group' => 'users',
        'action' => 'create',
        'description' => 'Create users',
        'is_active' => true
    ]);
    echo "✅ Permission: " . $userCreate->name . "\n";

    // Crear módulos
    $dashboard = Kaely\Access\Models\Module::firstOrCreate([
        'name' => 'dashboard'
    ], [
        'slug' => 'dashboard',
        'description' => 'Dashboard Module',
        'icon' => 'fas fa-home',
        'sort_order' => 1,
        'is_active' => true
    ]);
    echo "✅ Module: " . $dashboard->name . "\n";

    $users = Kaely\Access\Models\Module::firstOrCreate([
        'name' => 'users'
    ], [
        'slug' => 'users',
        'description' => 'Users Module',
        'icon' => 'fas fa-users',
        'sort_order' => 2,
        'is_active' => true
    ]);
    echo "✅ Module: " . $users->name . "\n";

    echo "\n🎯 VitalAccess data created successfully!\n";
    echo "\nData summary:\n";
    echo "- Roles: " . Kaely\Access\Models\Role::count() . "\n";
    echo "- Permissions: " . Kaely\Access\Models\Permission::count() . "\n";
    echo "- Modules: " . Kaely\Access\Models\Module::count() . "\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}