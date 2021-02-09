<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Rol extends Model
{
    protected $table = "roles";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function roles()
    {
        return $this->belongsToMany(Usuario::class, 'usuarios_roles', 'rol_id', 'usuario_id');
    }
}
