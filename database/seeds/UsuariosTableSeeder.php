<?php

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 5; $i++ ){
            $data = [
                "nombre" => $faker->name,
                "email" => $faker->email,
            ];
            Usuario::create($data);
        }
    }
}
