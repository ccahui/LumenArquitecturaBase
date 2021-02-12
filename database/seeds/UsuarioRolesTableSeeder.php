<?php

use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuarioRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = Usuario::all();
        $roles = Rol::all();
        $rolesIds = $roles->pluck('id');
        foreach($usuarios as $user){
            $user->roles()->attach($rolesIds);
        }
    }
}
