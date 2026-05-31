<?php

namespace App\Controllers;

use App\Models\ProductoModel;

class Catalog extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();
        
        // Fetch all products
        $products = $productoModel->findAll();

        return view('catalog/index', [
            'products' => $products,
            'title'    => 'Catálogo - Magic Shop'
        ]);
    }
}
