<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'usuarios.ver',
            'usuarios.crear',
            'usuarios.editar',
            'usuarios.eliminar',
            'documentos.ver',
            'documentos.crear',
            'documentos.editar',
            'documentos.eliminar',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(
                ['name' => $perm, 'guard_name' => 'web']
            );
        }

        // 2. Crear roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $archivista = Role::firstOrCreate(['name' => 'archivista', 'guard_name' => 'web']);
        $consulta   = Role::firstOrCreate(['name' => 'consulta', 'guard_name' => 'web']);

        // 3. Asignar permisos por rol
        $superAdmin->syncPermissions(Permission::all());

        $archivista->syncPermissions([
            'documentos.ver',
            'documentos.crear',
            'documentos.editar',
        ]);

        $consulta->syncPermissions([
            'documentos.ver',
        ]);

        // 4. Crear usuario administrador por defecto
        $admin = User::firstOrCreate(
            ['email' => 'admin@archivo-muni.test'],
            [
                'name' => 'Administrador General',
                'password' => bcrypt('admin123'), // puedes cambiarla después
            ]
        );

        if (! $admin->hasRole('super-admin')) {
            $admin->assignRole('super-admin');
        }
    }
}
