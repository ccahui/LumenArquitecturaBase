<?php

use App\Models\Rol;
use App\Models\Usuario;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ModelUsuarioRolTest extends TestCase
{
    private $usuario;
    private $role;
    use DatabaseMigrations;
    

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::create(["nombre" => "test", "email" => "test@example.com"]);
        $this->role = Rol::create(["nombre"=>"admin"]);
        
    }

    public function test_create_usuario_role(){
       
        $this->usuario->roles()->attach($this->role->id);
        $roles = $this->usuario->roles;
        
        $this->assertCount(1, $roles);

    }


}
