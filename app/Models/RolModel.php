<?php

namespace App\Models;

use CodeIgniter\Model;

class RolModel extends Model
{
    protected $table            = 'roles';
    protected $primaryKey       = 'id_rol';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre_rol'];

    // Validation
    protected $validationRules      = [
        'nombre_rol' => 'required|min_length[3]|max_length[50]|is_unique[roles.nombre_rol,id_rol,{id_rol}]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
