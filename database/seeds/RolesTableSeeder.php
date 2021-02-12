<?php

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     Rol::create(["nombre"=>"ADMIN"]);
     Rol::create(["nombre"=>"USUARIO"]);   
    }
}
