<?php

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

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
                "password" => Hash::make('123456'),
            ];
            Usuario::create($data);
        }

        $data = [
            "nombre" => $faker->name,
            "email" => "test@example.com",
            "password" => Hash::make('123456'),
        ];
        Usuario::create($data);
    }
}
