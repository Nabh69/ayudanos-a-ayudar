<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{User,Dog,Need};
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {public function run(): void {
 if(app()->environment('production'))throw new \RuntimeException('No cargar datos demostrativos en producción.');
 foreach(['admin'=>'Administrador demo','volunteer'=>'Voluntaria demo','supporter'=>'Colaborador demo'] as $role=>$name){$u=User::firstOrNew(['email'=>$role.'@demo.test']);$u->forceFill(['name'=>$name,'password'=>Hash::make('DemoLocal!2026'),'role'=>$role])->save();}
 foreach([['Luna','2 años','hembra','mediano','Curiosa y tranquila. Esta ficha es un ejemplo para probar el proceso de adopción.'],['Bruno','4 años','macho','grande','Compañero de paseos y tardes al sol. Datos ficticios de demostración.'],['Mila','1 año','hembra','pequeño','Pequeña exploradora con mucha energía. Datos ficticios de demostración.']] as [$name,$age,$sex,$size,$description])Dog::firstOrCreate(['name'=>$name],['age_text'=>$age,'sex'=>$sex,'size'=>$size,'description'=>$description,'is_published'=>true]);
 foreach([['Alimento para perros',20,'alta'],['Materiales de limpieza',10,'media'],['Mantas para descansar',15,'media']] as [$title,$quantity,$priority])Need::firstOrCreate(['title'=>$title],['description'=>'Necesidad de ejemplo. Coordinar las características y entrega con el albergue.','quantity'=>$quantity,'priority'=>$priority]);
}}
