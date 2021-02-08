<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    private $rulesCreation =  [
        'nombre'=>'required',
        'email'=>'required | email ',
    ];

    public function index(Request $request)
    {
      return Usuario::all();
    }

    public function store(Request $request)
    {
    
        $this->validate($request, $this->rulesCreation);
        
        $inputs = $request->all();
        $usuario = Usuario::create($inputs);
        
        return $usuario;
    }
    public function show($id)
    {
        return Usuario::find($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesCreation);
        
        $usuario = Usuario::findOrFail($id);
        $usuario->update($request->all());

        return $usuario;
    }

    
    public function destroy($id)
    {
        Usuario::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

    /*Override */
    protected function buildFailedValidationResponse(Request $request, array $errors) {
        return response($errors, 400);
    }
}
