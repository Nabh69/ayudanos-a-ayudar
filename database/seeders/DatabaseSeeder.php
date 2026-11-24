<?php

namespace Database\Seeders;

use App\Models\Dog;
use App\Models\Cat;
use App\Models\Need;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            throw new \RuntimeException('No cargar datos demostrativos en producción.');
        }
        foreach (['admin' => 'Administrador demo', 'volunteer' => 'Voluntaria demo', 'supporter' => 'Colaborador demo'] as $role => $name) {
            $u = User::firstOrNew(['email' => $role.'@demo.test']);
            $u->forceFill(['name' => $name, 'password' => Hash::make('DemoLocal!2026'), 'role' => $role])->save();
        }
        foreach ([['Luna', '2 años', 'hembra', 'mediano', 'Curiosa y tranquila. Esta ficha es un ejemplo para probar el proceso de adopción.'], ['Bruno', '4 años', 'macho', 'grande', 'Compañero de paseos y tardes al sol. Datos ficticios de demostración.'], ['Mila', '1 año', 'hembra', 'pequeño', 'Pequeña exploradora con mucha energía. Datos ficticios de demostración.']] as [$name,$age,$sex,$size,$description]) {
            Dog::firstOrCreate(['name' => $name], ['age_text' => $age, 'sex' => $sex, 'size' => $size, 'description' => $description, 'is_published' => true]);
        }
        foreach ([['Bella', 'Cachorra', 'hembra', 'pequeño', 'Cachorra cariñosa en busca de un hogar responsable.'], ['Roky', 'Cachorro', 'macho', 'pequeño', 'Cachorro juguetón y cariñoso.'], ['Rambo', 'Cachorro', 'macho', 'pequeño', 'Cachorro tranquilo que espera una familia.'], ['Hércules', 'Cachorro', 'macho', 'pequeño', 'Cachorro noble y atento, listo para una adopción responsable.']] as [$name,$age,$sex,$size,$description]) {
            Dog::firstOrCreate(['name' => $name], ['age_text' => $age, 'sex' => $sex, 'size' => $size, 'description' => $description, 'is_published' => true, 'adoption_status' => 'disponible']);
        }
        foreach ([
            ['Blanquita', 'Aproximadamente 1 mes y medio', 'Hembra', 'Ya come croquetas. Es muy educada y cariñosa; busca un hogar responsable.', 'images/cats/blanquita.jpg'],
            ['Machito', 'Aproximadamente 1 mes y medio', 'Macho', 'Ya come croquetas. Es muy educado y cariñoso; busca un hogar responsable.', 'images/cats/machito.jpg'],
            ['Camada de gatitos', '2 meses', 'Varios', 'Ya comen solitos, están sanitos y son muy juguetones y cariñosos.', 'images/cats/camada.jpg'],
            ['Michi gris', 'Sin dato', 'Sin dato', 'Un gatito dulce que espera una familia responsable.', 'images/cats/michi-gris.jpg'],
        ] as [$name,$age,$sex,$description,$photo]) {
            Cat::updateOrCreate(['name' => $name], ['age_text' => $age, 'sex' => $sex, 'description' => $description, 'photo_path' => $photo, 'adoption_status' => 'disponible', 'is_published' => true]);
        }
        foreach ([['Alimento para perros', 20, 'alta'], ['Materiales de limpieza', 10, 'media'], ['Mantas para descansar', 15, 'media']] as [$title,$quantity,$priority]) {
            Need::firstOrCreate(['title' => $title], ['description' => 'Necesidad de ejemplo. Coordinar las características y entrega con el albergue.', 'quantity' => $quantity, 'priority' => $priority]);
        }
    }
}
