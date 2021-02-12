<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this -> eliminarDatosDeLasTablas([
            'usuarios',
            'roles',
            'usuarios_roles',
        ]);
         $this->call('UsuariosTableSeeder');
         $this->call('RolesTableSeeder');
         $this->call('UsuarioRolesTableSeeder');
    }
    
    private function eliminarDatosDeLasTablas(array $tablas){
        $this-> desabilitarRevisionForeignKey();
        foreach($tablas as $tabla){
            DB::table($tabla)->truncate();
        }
        $this-> habilitarRevisionForeignKey();
    }
   
    private function desabilitarRevisionForeignKey(){
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    }
        
    private function habilitarRevisionForeignKey(){
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
