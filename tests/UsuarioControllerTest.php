<?php

use App\Models\Rol;
use App\Models\TypeRoles;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UsuarioControllerTest extends TestCase
{
    private $usuario;
    private $tabla = 'usuarios';
    use DatabaseMigrations;


    protected function setUp(): void
    {
        parent::setUp();

        $this->crearUsuarioConRoles();
        $this->authCredentialsToken();
    }

    public function test_login()
    {
        $email = $this->usuario->email;
        $password = "123456";
        $body = ["email" => $email, "password" => $password];
        $url = route('login');

        $response = $this->post($url, $body);
        
        $response->assertResponseStatus(200);
    }

    public function test_index()
    {
        $url = route('usuarios');

        $response = $this->get($url);

        $response->assertResponseStatus(200);
    }

    public function test_store()
    {
        $body = ["nombre" => "Kristian", "email" => "ccahui@gmail.com", "password" => "123456"];
        $url = route('usuarios');

        $response = $this->post($url, $body);
        unset($body['password']);
        
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
        $role = Rol::create(["nombre" => "otroRol"]);
        $body = [
            "rolesIds" => [$role->id],
        ];
        $id = $this->usuario->id;
        $url = $this->urlWithId($id) . "/roles";
        
        $response = $this->post($url, $body);
        
        $response->assertResponseStatus(200);
    }

    public function urlWithId($id)
    {
        $urlBase = route('usuarios');
        return "{$urlBase}/{$id}";
    }

    private function crearUsuarioConRoles()
    {
        
        $this->crearUsuario();
        $this->createRoles();
        $this->attachRoles();
        
    }
    private function crearUsuario(){
        $this->usuario = new Usuario;
        $this->usuario->nombre = "test";
        $this->usuario->email = "test@example.com";
        $this->usuario->password = Hash::make("123456");

        $this->usuario->save();
    }

    private function createRoles()
    {
        app(DatabaseSeeder::class)->call(RolesTableSeeder::class);
    }
    
    private function attachRoles(){
        $roles = Rol::all();
        $rolesIds = $roles->pluck('id');

        $this->usuario->roles()->attach($rolesIds);
    }
    
    private function authCredentialsToken()
    {
        $email = $this->usuario->email;
        $password = "123456";
        $credentials = [
            'email' => $email,
            'password' => $password
        ];
        Auth::attempt($credentials);
    }
}
