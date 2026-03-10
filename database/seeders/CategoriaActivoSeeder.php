<?php

namespace Database\Seeders;

use App\Models\CategoriaActivo;
use Illuminate\Database\Seeder;

class CategoriaActivoSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Computador / Laptop',
                'icono'  => '💻',
                'campos' => [
                    ['clave' => 'marca',        'label' => 'Marca',           'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'modelo',       'label' => 'Modelo',          'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'numero_serie', 'label' => 'Número de serie', 'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'color',        'label' => 'Color',           'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'procesador',   'label' => 'Procesador',      'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'ram',          'label' => 'RAM',             'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'almacenamiento','label'=> 'Almacenamiento',  'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'ubicacion',    'label' => 'Ubicación',       'tipo' => 'text',   'requerido' => false],
                ],
            ],
            [
                'nombre' => 'Impresora / Escáner',
                'icono'  => '🖨️',
                'campos' => [
                    ['clave' => 'marca',        'label' => 'Marca',           'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'modelo',       'label' => 'Modelo',          'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'numero_serie', 'label' => 'Número de serie', 'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'tipo',         'label' => 'Tipo',            'tipo' => 'select', 'requerido' => false,
                     'opciones' => ['Láser', 'Inyección de tinta', 'Multifuncional', 'Escáner']],
                    ['clave' => 'ubicacion',    'label' => 'Ubicación',       'tipo' => 'text',   'requerido' => false],
                ],
            ],
            [
                'nombre' => 'Vehículo',
                'icono'  => '🚗',
                'campos' => [
                    ['clave' => 'marca',        'label' => 'Marca',           'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'modelo',       'label' => 'Modelo',          'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'placa',        'label' => 'Placa',           'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'anio',         'label' => 'Año',             'tipo' => 'number', 'requerido' => false],
                    ['clave' => 'color',        'label' => 'Color',           'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'kilometraje',  'label' => 'Kilometraje',     'tipo' => 'number', 'requerido' => false],
                    ['clave' => 'ubicacion',    'label' => 'Ubicación',       'tipo' => 'text',   'requerido' => false],
                ],
            ],
            [
                'nombre' => 'Herramienta',
                'icono'  => '🔧',
                'campos' => [
                    ['clave' => 'marca',        'label' => 'Marca',           'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'modelo',       'label' => 'Modelo',          'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'numero_serie', 'label' => 'Número de serie', 'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'tipo',         'label' => 'Tipo',            'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'ubicacion',    'label' => 'Ubicación',       'tipo' => 'text',   'requerido' => false],
                ],
            ],
            [
                'nombre' => 'Teléfono / Celular',
                'icono'  => '📱',
                'campos' => [
                    ['clave' => 'marca',        'label' => 'Marca',           'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'modelo',       'label' => 'Modelo',          'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'numero_serie', 'label' => 'Número de serie', 'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'imei',         'label' => 'IMEI',            'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'color',        'label' => 'Color',           'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'numero',       'label' => 'Número asignado', 'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'ubicacion',    'label' => 'Ubicación',       'tipo' => 'text',   'requerido' => false],
                ],
            ],
            [
                'nombre' => 'Mueble',
                'icono'  => '🪑',
                'campos' => [
                    ['clave' => 'tipo',         'label' => 'Tipo',            'tipo' => 'text',   'requerido' => true],
                    ['clave' => 'material',     'label' => 'Material',        'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'color',        'label' => 'Color',           'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'dimensiones',  'label' => 'Dimensiones',     'tipo' => 'text',   'requerido' => false],
                    ['clave' => 'ubicacion',    'label' => 'Ubicación',       'tipo' => 'text',   'requerido' => false],
                ],
            ],
        ];

        foreach ($categorias as $cat) {
            CategoriaActivo::firstOrCreate(
                ['nombre' => $cat['nombre'], 'empresa_id' => null],
                $cat
            );
        }

        $this->command->info('✅ Categorías globales creadas.');
    }
}