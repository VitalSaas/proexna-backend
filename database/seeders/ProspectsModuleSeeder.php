<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use VitalSaaS\VitalAccess\Models\AccessModule;
use VitalSaaS\VitalAccess\Models\AccessPermission;
use VitalSaaS\VitalAccess\Models\AccessRole;

class ProspectsModuleSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = $this->createPermissions();
        $module = $this->createModule();
        $module->permissions()->syncWithoutDetaching($permissions->pluck('id')->toArray());
        $this->grantToRoles($permissions);

        $this->command->info('✅ Módulo "Prospectos" registrado en VitalAccess.');
    }

    protected function createPermissions()
    {
        $items = [
            ['slug' => 'prospects.view',   'action' => 'view',   'name' => 'Ver Prospectos'],
            ['slug' => 'prospects.create', 'action' => 'create', 'name' => 'Crear Prospectos'],
            ['slug' => 'prospects.edit',   'action' => 'edit',   'name' => 'Editar Prospectos'],
            ['slug' => 'prospects.delete', 'action' => 'delete', 'name' => 'Eliminar Prospectos'],
        ];

        foreach ($items as $data) {
            AccessPermission::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'group' => 'prospects',
                    'description' => "Permite {$data['name']}",
                    'is_system' => false,
                ]),
            );
        }

        return AccessPermission::whereIn('slug', array_column($items, 'slug'))->get();
    }

    protected function createModule(): AccessModule
    {
        $crm = AccessModule::firstOrCreate(
            ['slug' => 'crm'],
            [
                'name' => 'CRM',
                'icon' => 'heroicon-o-rectangle-stack',
                'type' => 'group',
                'sort_order' => 5,
                'depth' => 0,
                'is_active' => true,
                'is_visible' => true,
            ],
        );

        return AccessModule::firstOrCreate(
            ['slug' => 'prospects'],
            [
                'parent_id' => $crm->id,
                'name' => 'Prospectos',
                'icon' => 'heroicon-o-funnel',
                'route' => null,
                'type' => 'menu',
                'sort_order' => 1,
                'depth' => 1,
                'is_active' => true,
                'is_visible' => true,
            ],
        );
    }

    protected function grantToRoles($permissions): void
    {
        $ids = $permissions->pluck('id')->toArray();

        foreach (['superadmin', 'admin', 'manager'] as $slug) {
            $role = AccessRole::where('slug', $slug)->first();
            if ($role) {
                $role->permissions()->syncWithoutDetaching($ids);
            }
        }
    }
}
