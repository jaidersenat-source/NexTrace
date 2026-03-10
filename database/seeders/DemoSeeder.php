<?php

namespace Database\Seeders;

use App\Models\Activo;
use App\Models\ActivityLog;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Empresa demo
        $empresa = Empresa::create([
            'nombre'           => 'Empresa Demo S.A.',
            'slug'             => 'demo',
            'email'            => 'demo@nextrace.com',
            'telefono'         => '+57 300 000 0000',
            'pais'             => 'Colombia',
            'activo'           => true,
            'plan'             => 'profesional',
            'color_primario'   => '#4f46e5',
            'color_secundario' => '#818cf8',
            'color_sidebar'    => '#1e1b4b',
        ]);

        // Admin demo
        $admin = User::create([
            'empresa_id' => $empresa->id,
            'nombre'     => 'Carlos',
            'apellido'   => 'Ramírez',
            'email'      => 'admin@demo.com',
            'password'   => Hash::make('password'),
            'rol'        => 'admin',
            'activo'     => true,
        ]);

        // Empleado demo
        User::create([
            'empresa_id' => $empresa->id,
            'nombre'     => 'Laura',
            'apellido'   => 'Gómez',
            'email'      => 'empleado@demo.com',
            'password'   => Hash::make('password'),
            'rol'        => 'empleado',
            'activo'     => true,
        ]);

        // Activos ficticios
        $activos = [
            ['nombre' => 'Laptop Dell XPS 15',        'codigo' => 'TEC-001', 'valor' => 3500000, 'estado' => 'activo'],
            ['nombre' => 'MacBook Pro M3',             'codigo' => 'TEC-002', 'valor' => 7800000, 'estado' => 'activo'],
            ['nombre' => 'Servidor HP ProLiant',       'codigo' => 'SRV-001', 'valor' => 12000000,'estado' => 'activo'],
            ['nombre' => 'Impresora Epson L3150',      'codigo' => 'IMP-001', 'valor' => 850000,  'estado' => 'mantenimiento'],
            ['nombre' => 'Monitor LG 27"',             'codigo' => 'MON-001', 'valor' => 1200000, 'estado' => 'activo'],
            ['nombre' => 'UPS APC 1500VA',             'codigo' => 'ELE-001', 'valor' => 950000,  'estado' => 'activo'],
            ['nombre' => 'Switch Cisco 24 puertos',    'codigo' => 'NET-001', 'valor' => 2300000, 'estado' => 'activo'],
            ['nombre' => 'Cámara de seguridad Dahua',  'codigo' => 'SEG-001', 'valor' => 480000,  'estado' => 'activo'],
            ['nombre' => 'Proyector Epson EB-X51',     'codigo' => 'AV-001',  'valor' => 1800000, 'estado' => 'mantenimiento'],
            ['nombre' => 'Silla ergonómica Herman',    'codigo' => 'MOB-001', 'valor' => 2100000, 'estado' => 'activo'],
            ['nombre' => 'Escritorio ejecutivo',       'codigo' => 'MOB-002', 'valor' => 1500000, 'estado' => 'activo'],
            ['nombre' => 'Teléfono IP Grandstream',    'codigo' => 'TEL-001', 'valor' => 320000,  'estado' => 'baja'],
            ['nombre' => 'NAS Synology DS923+',        'codigo' => 'SRV-002', 'valor' => 4200000, 'estado' => 'activo'],
            ['nombre' => 'iPad Pro 12.9"',             'codigo' => 'TEC-003', 'valor' => 4500000, 'estado' => 'activo'],
            ['nombre' => 'Router Mikrotik hEX',        'codigo' => 'NET-002', 'valor' => 680000,  'estado' => 'baja'],
        ];

        foreach ($activos as $index => $datos) {
            $activo = Activo::create(array_merge($datos, [
                'empresa_id'  => $empresa->id,
                'descripcion' => 'Activo generado para demostración del sistema.',
                'created_at'  => now()->subDays(rand(1, 180)),
            ]));

            // Logs de auditoría ficticios
            ActivityLog::create([
                'empresa_id'  => $empresa->id,
                'user_id'     => $admin->id,
                'action'      => 'create',
                'model'       => Activo::class,
                'model_id'    => $activo->id,
                'description' => "Activo '{$activo->nombre}' creado.",
                'created_at'  => $activo->created_at,
            ]);
        }

        $this->command->info('✅ Demo cargada: admin@demo.com / password');
    }
}