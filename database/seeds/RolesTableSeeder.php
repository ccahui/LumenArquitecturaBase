<?php

use App\Models\Rol;
use App\Models\TypeRoles;
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
        Rol::create(["nombre" => TypeRoles::ADMIN]);
        Rol::create(["nombre" => TypeRoles::USER]);
    }
}
