<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioService 
{
    public function listAll($pageSize)
    {
      return Usuario::paginate($pageSize);
    }

    public function login($credentials){
        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    
    public function create(Request $request)
    {   
        $user = new Usuario;
        $user->nombre = $request->input('nombre');
        $user->email = $request->input('email');
        $plainPassword = $request->input('password');
        $user->password = Hash::make($plainPassword);
        
        $user->save();
        return $user;
    }

    public function read($id)
    {
        $usuario = $this->find($id);
        $usuario->load('roles');
        return $usuario;   
    }
    
    public function update(Request $request, $id)
    {        
        $usuario = $this->find($id);
        $usuario->update($request->all());
        return $usuario;
    }

    public function delete($id)
    {
        Usuario::destroy($id);
    }
   
    public function attachRoles(Request $request, $id){
        $usuario = $this->find($id);
        $rolesIds = $request->input('rolesIds');
        
        $usuario->roles()->sync($rolesIds);
        $usuario->load('roles');
        
        return $usuario;
    }

    private function find($id){
        $usuario = Usuario::find($id);
        if(!$usuario){
            throw new NotFoundException("Usuario id ($id)");
        }
        return $usuario;
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 200);
    }
}
