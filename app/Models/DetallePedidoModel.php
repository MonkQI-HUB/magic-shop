<?php

namespace App\Models;

use CodeIgniter\Model;

class DetallePedidoModel extends Model
{
    protected $table            = 'detalles_pedido';
    protected $primaryKey       = 'id_detalle';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pedido',
        'id_producto',
        'cantidad',
        'precio_unitario'
    ];

    // Validation
    protected $validationRules      = [
        'id_pedido'       => 'required|integer',
        'id_producto'     => 'required|integer',
        'cantidad'        => 'required|integer|greater_than_equal_to[1]',
        'precio_unitario' => 'required|decimal|greater_than_equal_to[0]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
