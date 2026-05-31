<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PedidoModel;
use App\Models\DetallePedidoModel;

class Orders extends BaseController
{
    public function index()
    {
        $pedidoModel = new PedidoModel();
        
        // Fetch orders joined with usuarios for customer names
        $orders = $pedidoModel->select('pedidos.*, usuarios.nombre, usuarios.apellido')
                              ->join('usuarios', 'usuarios.id_usuario = pedidos.id_usuario')
                              ->orderBy('pedidos.fecha_pedido', 'DESC')
                              ->findAll();
        
        return view('admin/orders', [
            'orders' => $orders,
            'title'  => 'Control de Pedidos - Admin'
        ]);
    }

    public function details($id)
    {
        $detalleModel = new DetallePedidoModel();
        
        // Fetch details joined with products for product names
        $details = $detalleModel->select('detalles_pedido.*, productos.nombre_producto, productos.imagen_url')
                                ->join('productos', 'productos.id_producto = detalles_pedido.id_producto')
                                ->where('detalles_pedido.id_pedido', $id)
                                ->findAll();
        
        // Resolver URLs de imágenes locales para que el modal JS las cargue correctamente
        foreach ($details as &$item) {
            if (!filter_var($item['imagen_url'], FILTER_VALIDATE_URL)) {
                $item['imagen_url'] = base_url($item['imagen_url']);
            }
        }
        
        return $this->response->setJSON([
            'status'  => 'success',
            'details' => $details
        ]);
    }

    public function updateStatus($id)
    {
        $pedidoModel = new PedidoModel();
        $pedido = $pedidoModel->find($id);

        if (!$pedido) {
            session()->setFlashdata('error', 'Pedido no encontrado.');
            return redirect()->to(base_url('admin/orders'));
        }

        $estado = $this->request->getPost('estado');
        
        if (in_array($estado, ['Pendiente', 'Procesando', 'Enviado', 'Completado', 'Cancelado'])) {
            $pedidoModel->update($id, ['estado' => $estado]);
            session()->setFlashdata('success', 'Estado del pedido actualizado con éxito.');
        } else {
            session()->setFlashdata('error', 'Estado de pedido inválido.');
        }

        return redirect()->to(base_url('admin/orders'));
    }
}
