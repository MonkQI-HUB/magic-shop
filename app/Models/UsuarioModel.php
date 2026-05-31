<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_rol',
        'correo_electronico',
        'password_hash',
        'nombre',
        'apellido',
        'edad',
        'telefono'
    ];

    // Validation
    protected $validationRules      = [
        'id_rol'             => 'required|integer',
        'correo_electronico' => 'required|valid_email|max_length[100]|is_unique[usuarios.correo_electronico,id_usuario,{id_usuario}]',
        'password_hash'      => 'required|max_length[255]',
        'nombre'             => 'required|min_length[2]|max_length[50]',
        'apellido'           => 'required|min_length[2]|max_length[50]',
        'edad'               => 'permit_empty|integer|greater_than[0]',
        'telefono'           => 'required|min_length[7]|max_length[15]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
