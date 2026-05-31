<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\UsuarioModel;
use App\Models\ProductoModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $pedidoModel = new PedidoModel();
        $usuarioModel = new UsuarioModel();
        $productoModel = new ProductoModel();

        // 1. Total Sales
        $sales = $pedidoModel->selectSum('total')->first();
        $totalSales = $sales['total'] ?: 0.00;

        // 2. Count of orders
        $totalOrders = $pedidoModel->countAllResults();

        // 3. Count of customers
        $totalCustomers = $usuarioModel->where('id_rol', 1)->countAllResults();

        // 4. Low stock items
        $lowStock = $productoModel->where('stock <=', 5)->countAllResults();

        return view('admin/dashboard', [
            'totalSales'     => $totalSales,
            'totalOrders'    => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'lowStock'       => $lowStock,
            'title'          => 'Admin Dashboard - Magic Shop'
        ]);
    }
}
