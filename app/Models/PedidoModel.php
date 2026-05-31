<?php

namespace App\Models;

use CodeIgniter\Model;

class PedidoModel extends Model
{
    protected $table            = 'pedidos';
    protected $primaryKey       = 'id_pedido';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_usuario',
        'total',
        'estado'
    ];

    // Validation
    protected $validationRules      = [
        'id_usuario' => 'required|integer',
        'total'      => 'required|decimal|greater_than_equal_to[0]',
        'estado'     => 'required|in_list[Pendiente,Procesando,Enviado,Completado,Cancelado]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
