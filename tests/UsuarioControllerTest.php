<?php

use App\Models\Rol;
use App\Models\Usuario;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UsuarioControllerTest extends TestCase
{
    private $usuario;
    private $tabla = 'usuarios';
    use DatabaseMigrations;
    

    protected function setUp(): void
    {
        parent::setUp();
        $this->usuario = Usuario::create(["nombre" => "test", "email" => "test@example.com"]);
    }

    public function test_index()
    {
        $body = $this->usuario->toArray();
        $url = route('usuarios');
        $response = $this->get($url);

        $response->assertResponseStatus(200);
        $response->seeJson($body);
    }

    public function test_store()
    {
        $body = ["nombre" => "Kristian", "email" => "ccahui@gmail.com"];
        $url = route('usuarios');

        $response = $this->post($url, $body);

        $response->assertResponseStatus(200);
        $response->seeInDatabase($this->tabla, $body);
        $response->seeJson($body);
    }

    public function test_update()
    {
        $body = ["nombre" => "Kristian", "email" => "kristianccahui@gmail.com"];
        $id = $this->usuario->id;
        
        $url = $this->urlWithId($id);
        $response = $this->put($url, $body);

        $response->assertResponseStatus(200);
        $response->seeInDatabase($this->tabla, $body);
        $response->seeJson($body);
    }

    public function test_update404()
    {
        $body = ["nombre" => "Kristian", "email" => "kristianccahui@gmail.com"];
        $id = 999;
        
        $url = $this->urlWithId($id);
        $response = $this->put($url, $body);

        $response->assertResponseStatus(404);
    }

    public function test_show()
    {
        $body = $this->usuario->toArray();

        $id = $this->usuario->id;
        $url = $this->urlWithId($id);
     
        $response = $this->get($url);

        $response->assertResponseStatus(200);
        $response->seeJson($body);
    }

    public function test_show404()
    {
        
        $id = 999;
        $url = $this->urlWithId($id);
        $response = $this->get($url);

        $response->assertResponseStatus(404);
    }

    public function test_delete()
    {
        $id = $this->usuario->id;
        $url = $this->urlWithId($id);
     
        $response = $this->delete($url);

        $response->assertResponseStatus(200);
        $this->notSeeInDatabase($this->tabla, ['id' => $id]);
    }
    
    public function test_delete_idNotExist()
    {
        $id = 999;
        $url = $this->urlWithId($id);
     
        $response = $this->delete($url);

        $response->assertResponseStatus(200);
    }

    
    public function test_attachRoles()
    {
        $role = Rol::create(["nombre"=>"admin"]);
        $body = [
            "rolesIds"=> [$role->id],
        ];
        $id = $this->usuario->id;
        
        $url = $this->urlWithId($id)."/roles";
        $response = $this->post($url, $body);
        $response->assertResponseStatus(200);
    }



    public function urlWithId($id){
        $urlBase = route('usuarios');
        return "{$urlBase}/{$id}";
    }
}
