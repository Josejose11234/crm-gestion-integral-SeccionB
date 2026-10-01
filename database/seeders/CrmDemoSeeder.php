<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrmDemoSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. ASESORES (usuarios del CRM)
        // ==========================================
        foreach (['Ana Rodriguez', 'Carlos Pérez', 'María González'] as $name) {
            DB::table('users')->insert([
                'name'       => $name,
                'email'      => strtolower(str_replace(' ', '.', $name)) . '@crm.com',
                'password'   => bcrypt('123456'),   // contraseña por defecto
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ==========================================
        // 2. ORÍGENES de los clientes
        // ==========================================
        foreach (['Redes Sociales', 'Recomendación', 'Web', 'Evento', 'Otro'] as $nombre) {
            DB::table('origins')->insert([
                'nombre'     => $nombre,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // ==========================================
        // 3. CLIENTES (15 empresas distribuidas)
        // ==========================================
        $zonas = ['Oeste', 'Este', 'Cabudare', 'Centro', 'Zona Industrial'];
        $empresas = [
            'Distribuidora Lara C.A.', 'Tecnoservicios Barquisimeto',
            'Ferretería El Tornillo', 'Panificadora La Espiga',
            'Auto Repuestos Central', 'Farmacia Salud Total',
            'Comercial Los Andes', 'Servicios Técnicos Zulia',
            'Inversiones Barquisimeto', 'Textiles del Centro',
            'Alimentos del Este', 'Logística Express Lara',
            'Constructora Occidente', 'Repuestos Cabudare', 'Mini Market 24',
        ];

        foreach ($empresas as $i => $empresa) {
            DB::table('clients')->insert([
                'nombre_empresa'     => $empresa,
                'contacto_principal' => 'Contacto ' . ($i + 1),
                'telefono_whatsapp'  => '58414' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT),
                'zona_geografica'    => $zonas[$i % 5],
                'user_id'            => ($i % 3) + 1,   // 1, 2 o 3 (Ana, Carlos, María)
                'origin_id'          => ($i % 5) + 1,   // 1 a 5
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }

        // ==========================================
        // 4. INTERACCIONES (3 a 6 por cada cliente)
        // ==========================================
        $tipos = ['Llamada', 'Visita', 'WhatsApp'];

        foreach (DB::table('clients')->get() as $client) {
            foreach (range(1, rand(3, 6)) as $j) {
                DB::table('interactions')->insert([
                    'client_id'         => $client->id,
                    'tipo_interaccion'  => $tipos[array_rand($tipos)],
                    'observaciones'     => 'Seguimiento #' . $j,
                    'fecha_seguimiento' => now()->subDays(rand(1, 60)),
                    'created_at'        => now(),
                    'updated_at'        => now(),
                ]);
            }
        }

        $this->command->info('✅ CRM poblado con datos de prueba.');
    }
}