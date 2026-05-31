<?php

namespace App\Controllers;

use App\Models\ProductoModel;
use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;

class Cart extends BaseController
{
    private function getCartSession()
    {
        return session()->get('cart') ?: ['items' => []];
    }

    private function saveCartSession($cart)
    {
        session()->set('cart', $cart);
    }

    public function index()
    {
        $cart = $this->getCartSession();
        return view('cart/checkout', [
            'cart'  => $cart,
            'title' => 'Carrito - Magic Shop'
        ]);
    }

    public function get()
    {
        $cart = $this->getCartSession();
        $grand_total = 0;
        $total_items = 0;

        foreach ($cart['items'] as &$item) {
            $item['subtotal'] = $item['precio'] * $item['cantidad'];
            $grand_total += $item['subtotal'];
            $total_items += $item['cantidad'];
        }

        $cart['grand_total'] = $grand_total;
        $cart['total_items'] = $total_items;

        return $this->response->setJSON([
            'status' => 'success',
            'cart'   => $cart
        ]);
    }

    public function add()
    {
        $id_producto = $this->request->getPost('id_producto');
        $cantidad = intval($this->request->getPost('cantidad') ?: 1);

        if (!$id_producto || $cantidad <= 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Parámetros inválidos.'
            ]);
        }

        $productoModel = new ProductoModel();
        $product = $productoModel->find($id_producto);

        if (!$product) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Producto no encontrado.'
            ]);
        }

        $cart = $this->getCartSession();
        
        // Find if already in cart
        $foundIndex = -1;
        foreach ($cart['items'] as $index => $item) {
            if ($item['id_producto'] == $id_producto) {
                $foundIndex = $index;
                break;
            }
        }

        $currentQtyInCart = ($foundIndex !== -1) ? $cart['items'][$foundIndex]['cantidad'] : 0;
        $newQty = $currentQtyInCart + $cantidad;

        // Check stock
        if ($product['stock'] < $newQty) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "Cantidad no disponible en inventario. Stock disponible: {$product['stock']}."
            ]);
        }

        if ($foundIndex !== -1) {
            $cart['items'][$foundIndex]['cantidad'] = $newQty;
        } else {
            $cart['items'][] = [
                'id_producto'     => $product['id_producto'],
                'nombre_producto' => $product['nombre_producto'],
                'precio'          => floatval($product['precio']),
                'imagen_url' => $product['imagen_url'],
                'cantidad'        => $cantidad
            ];
        }

        $this->saveCartSession($cart);

        // Count total items
        $total_items = 0;
        foreach ($cart['items'] as $item) {
            $total_items += $item['cantidad'];
        }

        return $this->response->setJSON([
            'status'      => 'success',
            'message'     => 'Producto añadido al carrito con éxito.',
            'total_items' => $total_items
        ]);
    }

    public function update()
    {
        $id_producto = $this->request->getPost('id_producto');
        $cantidad = intval($this->request->getPost('cantidad'));

        if (!$id_producto || $cantidad <= 0) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Cantidad inválida.'
            ]);
        }

        $productoModel = new ProductoModel();
        $product = $productoModel->find($id_producto);

        if (!$product) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Producto no encontrado.'
            ]);
        }

        if ($product['stock'] < $cantidad) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "Cantidad no disponible. Stock disponible: {$product['stock']}."
            ]);
        }

        $cart = $this->getCartSession();
        $grand_total = 0;

        foreach ($cart['items'] as &$item) {
            if ($item['id_producto'] == $id_producto) {
                $item['cantidad'] = $cantidad;
            }
            $grand_total += $item['precio'] * $item['cantidad'];
        }

        $this->saveCartSession($cart);

        return $this->response->setJSON([
            'status'      => 'success',
            'message'     => 'Cantidad actualizada.',
            'grand_total' => $grand_total
        ]);
    }

    public function remove()
    {
        $id_producto = $this->request->getPost('id_producto');

        if (!$id_producto) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID de producto inválido.'
            ]);
        }

        $cart = $this->getCartSession();
        
        foreach ($cart['items'] as $index => $item) {
            if ($item['id_producto'] == $id_producto) {
                unset($cart['items'][$index]);
                break;
            }
        }

        // Re-index array
        $cart['items'] = array_values($cart['items']);
        $this->saveCartSession($cart);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Producto removido del carrito.'
        ]);
    }

    public function checkout()
    {
        if (!session()->get('logged_in')) {
            session()->setFlashdata('error', 'Por favor inicia sesión para completar tu compra.');
            return redirect()->to(base_url('login'));
        }

        $cart = $this->getCartSession();

        if (empty($cart['items'])) {
            session()->setFlashdata('error', 'El carrito está vacío.');
            return redirect()->to(base_url());
        }

        $db = \Config\Database::connect();
        $productoModel = new ProductoModel();
        $pedidoModel = new PedidoModel();
        $detalleModel = new DetallePedidoModel();

        // Start Transaction
        $db->transStart();

        $grand_total = 0;

        // 1. Verify stock for each item before inserting anything
        foreach ($cart['items'] as $item) {
            $product = $productoModel->find($item['id_producto']);
            if (!$product || $product['stock'] < $item['cantidad']) {
                $db->transRollback();
                session()->setFlashdata('error', "Lo sentimos, el producto '" . esc($item['nombre_producto']) . "' no cuenta con suficiente stock en este momento.");
                return redirect()->back();
            }
            $grand_total += floatval($product['precio']) * $item['cantidad'];
        }

        // 2. Insert Pedido Header
        $pedidoData = [
            'id_usuario' => session()->get('id_usuario'),
            'total'      => $grand_total,
            'estado'     => 'Pendiente'
        ];
        
        $pedidoModel->insert($pedidoData);
        $id_pedido = $pedidoModel->getInsertID();

        // 3. Insert DetallePedido and update stock
        foreach ($cart['items'] as $item) {
            $product = $productoModel->find($item['id_producto']);

            $detalleData = [
                'id_pedido'       => $id_pedido,
                'id_producto'     => $item['id_producto'],
                'cantidad'        => $item['cantidad'],
                'precio_unitario' => floatval($product['precio'])
            ];
            $detalleModel->insert($detalleData);

            // Decrement Stock
            $newStock = $product['stock'] - $item['cantidad'];
            $productoModel->update($item['id_producto'], ['stock' => $newStock]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Ocurrió un error al procesar el pedido. Intente nuevamente.');
            return redirect()->back();
        }

        // Clear cart session
        session()->remove('cart');

        session()->setFlashdata('success', '¡Su pedido ha sido procesado de forma exitosa! Gracias por su compra.');
        return redirect()->to(base_url());
    }
}
