<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductoModel extends Model
{
    protected $table            = 'productos';
    protected $primaryKey       = 'id_producto';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre_producto',
        'categoria',
        'precio',
        'stock',
        'imagen_url'
    ];

    // Validation
    protected $validationRules      = [
        'nombre_producto' => 'required|min_length[3]|max_length[100]',
        'categoria'       => 'permit_empty|max_length[50]',
        'precio'          => 'required|numeric|greater_than_equal_to[0]',
        'stock'           => 'required|integer|greater_than_equal_to[0]',
        'imagen_url'      => 'required|max_length[255]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
