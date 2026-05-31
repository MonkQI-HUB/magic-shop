<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductoModel;

class Catalog extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();
        $products = $productoModel->findAll();
        
        return view('admin/catalog', [
            'products' => $products,
            'title'    => 'Gestión de Catálogo - Admin'
        ]);
    }

    public function add()
    {
        $productoModel = new ProductoModel();

        $rules = [
            'nombre_producto' => 'required|min_length[3]|max_length[100]',
            'categoria'       => 'permit_empty|max_length[50]',
            'precio'          => 'required|numeric|greater_than_equal_to[0]',
            'stock'           => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Error de validación: ' . implode(' ', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $imgFile = $this->request->getFile('imagen');
        if ($imgFile && $imgFile->isValid() && !$imgFile->hasMoved()) {
            // Asegurar que el directorio de uploads existe
            $uploadDir = FCPATH . 'uploads/productos';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generar nombre seguro aleatorio y mover
            $newName = $imgFile->getRandomName();
            $imgFile->move($uploadDir, $newName);
            $imagen_url = 'uploads/productos/' . $newName;
        } else {
            session()->setFlashdata('error', 'Debe seleccionar una foto válida para el artículo.');
            return redirect()->back()->withInput();
        }

        $data = [
            'nombre_producto' => $this->request->getPost('nombre_producto'),
            'categoria'       => $this->request->getPost('categoria'),
            'precio'          => floatval($this->request->getPost('precio')),
            'stock'           => intval($this->request->getPost('stock')),
            'imagen_url'      => $imagen_url
        ];

        if ($productoModel->insert($data)) {
            session()->setFlashdata('success', 'Producto añadido con éxito.');
        } else {
            $modelErrors = $productoModel->errors() ? implode(' ', $productoModel->errors()) : '';
            session()->setFlashdata('error', 'No se pudo guardar el producto. ' . $modelErrors);
        }

        return redirect()->to(base_url('admin/catalog'));
    }

    public function edit($id)
    {
        $productoModel = new ProductoModel();
        $product = $productoModel->find($id);

        if (!$product) {
            session()->setFlashdata('error', 'Producto no encontrado.');
            return redirect()->to(base_url('admin/catalog'));
        }

        $rules = [
            'nombre_producto' => 'required|min_length[3]|max_length[100]',
            'categoria'       => 'permit_empty|max_length[50]',
            'precio'          => 'required|numeric|greater_than_equal_to[0]',
            'stock'           => 'required|integer|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Error de validación: ' . implode(' ', $this->validator->getErrors()));
            return redirect()->back();
        }

        $imagen_url = $product['imagen_url']; // Mantener la anterior por defecto

        $imgFile = $this->request->getFile('imagen');
        if ($imgFile && $imgFile->isValid() && !$imgFile->hasMoved()) {
            // Asegurar que el directorio de uploads existe
            $uploadDir = FCPATH . 'uploads/productos';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generar nombre seguro aleatorio y mover
            $newName = $imgFile->getRandomName();
            $imgFile->move($uploadDir, $newName);
            $imagen_url = 'uploads/productos/' . $newName;

            // Eliminar imagen local antigua si existe para no acumular basura
            if (!filter_var($product['imagen_url'], FILTER_VALIDATE_URL)) {
                $oldImagePath = FCPATH . $product['imagen_url'];
                if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $data = [
            'nombre_producto' => $this->request->getPost('nombre_producto'),
            'categoria'       => $this->request->getPost('categoria'),
            'precio'          => floatval($this->request->getPost('precio')),
            'stock'           => intval($this->request->getPost('stock')),
            'imagen_url'      => $imagen_url
        ];

        if ($productoModel->update($id, $data)) {
            session()->setFlashdata('success', 'Producto actualizado con éxito.');
        } else {
            $modelErrors = $productoModel->errors() ? implode(' ', $productoModel->errors()) : '';
            session()->setFlashdata('error', 'No se pudo actualizar el producto. ' . $modelErrors);
        }

        return redirect()->to(base_url('admin/catalog'));
    }

    public function delete($id)
    {
        $productoModel = new ProductoModel();
        $product = $productoModel->find($id);

        if (!$product) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Producto no encontrado.'
            ]);
        }

        try {
            if ($productoModel->delete($id)) {
                return $this->response->setJSON([
                    'status'  => 'success',
                    'message' => 'Producto eliminado con éxito.'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'No se puede eliminar el producto porque está asociado a pedidos existentes.'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'No se pudo eliminar el producto.'
        ]);
    }
}
