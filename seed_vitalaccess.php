<?php

echo "Creating basic VitalAccess data:\n";

// Create admin role
$admin = Kaely\Access\Models\Role::firstOrCreate([
    'name' => 'admin'
], [
    'slug' => 'admin',
    'description' => 'Administrator',
    'level' => 100,
    'is_active' => true
]);
echo "Admin role created: " . $admin->name . "\n";

// Create user permission
$userCreate = Kaely\Access\Models\Permission::firstOrCreate([
    'name' => 'users.create'
], [
    'slug' => 'users.create',
    'description' => 'Create users',
    'is_active' => true
]);
echo "Permission created: " . $userCreate->name . "\n";

// Create dashboard module
$dashboard = Kaely\Access\Models\Module::firstOrCreate([
    'name' => 'dashboard'
], [
    'slug' => 'dashboard',
    'description' => 'Dashboard module',
    'icon' => 'fas fa-home',
    'sort_order' => 1,
    'is_active' => true
]);
echo "Module created: " . $dashboard->name . "\n";

// Count all records
echo "\nCurrent data:\n";
echo "Roles: " . Kaely\Access\Models\Role::count() . "\n";
echo "Permissions: " . Kaely\Access\Models\Permission::count() . "\n";
echo "Modules: " . Kaely\Access\Models\Module::count() . "\n";