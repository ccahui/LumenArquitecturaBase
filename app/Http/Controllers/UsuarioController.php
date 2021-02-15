<?php

namespace App\Http\Controllers;

use App\Services\UsuarioService;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    private $rulesCreation =  [
        'nombre' => 'required',
        'email' => 'required | email ',
        'password'=> 'required'
    ];
    private $rulesUpdate =  [
        'nombre' => 'required',
        'email' => 'required | email ',
    ];
    private $service;

    public function __construct(UsuarioService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);
        return $this->service->login($credentials);
    }
    

    public function index()
    {   
        return $this->service->listAll($this->pageSize);
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rulesCreation);
        return $this->service->create($request);
    }

    public function show($id)
    {
        return $this->service->read($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, $this->rulesUpdate);
        return $this->service->update($request, $id);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
    }

    public function attachRoles(Request $request, $id)
    {
        $rules = [
            'rolesIds'   => 'array',
            'rolesIds.*' => 'integer|exists:roles,id',
        ];
        $this->validate($request, $rules);
       return $this->service->attachRoles($request, $id);
    }
}
