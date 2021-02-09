<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioService 
{

    public function listAll($pageSize)
    {
      return Usuario::paginate($pageSize);
    }

    public function create(Request $request)
    {   
        $inputs = $request->all();
        $usuario = Usuario::create($inputs);
        
        return $usuario;
    }

    public function read($id)
    {
        return $this->find($id);
    }

    public function update(Request $request, $id)
    {        
        $usuario = $this->find($id);
        $usuario->update($request->all());
        return $usuario;
    }

    public function delete($id)
    {
        Usuario::findOrFail($id)->delete();
    }
   
    private function find($id){
        $usuario = Usuario::find($id);
        if(!$usuario){
            throw new NotFoundException("Usuario id ($id)");
        }
        return $usuario;
    }
}
