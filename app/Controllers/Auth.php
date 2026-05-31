<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Auth extends BaseController
{
    public function registerView()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url());
        }
        return view('auth/register');
    }

    public function loginView()
    {
        if (session()->get('logged_in')) {
            return redirect()->to(base_url());
        }
        return view('auth/login');
    }

    public function register()
    {
        $usuarioModel = new UsuarioModel();

        $rules = [
            'nombre'             => 'required|min_length[2]|max_length[50]',
            'apellido'           => 'required|min_length[2]|max_length[50]',
            'correo_electronico' => 'required|valid_email|is_unique[usuarios.correo_electronico]',
            'password'           => 'required|min_length[8]',
            'telefono'           => 'required|min_length[7]|max_length[15]',
            'edad'               => 'permit_empty|integer|greater_than[0]'
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Por favor complete correctamente todos los campos. ' . implode(' ', $this->validator->getErrors()));
            return redirect()->back()->withInput();
        }

        $data = [
            'id_rol'             => 1, // Default user role
            'correo_electronico' => $this->request->getPost('correo_electronico'),
            'password_hash'      => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'nombre'             => $this->request->getPost('nombre'),
            'apellido'           => $this->request->getPost('apellido'),
            'telefono'           => $this->request->getPost('telefono'),
            'edad'               => $this->request->getPost('edad') ?: null
        ];

        if ($usuarioModel->insert($data)) {
            session()->setFlashdata('success', 'Cuenta creada con éxito. Por favor inicia sesión.');
            return redirect()->to(base_url('login'));
        } else {
            session()->setFlashdata('error', 'Ocurrió un error al crear la cuenta. Intente nuevamente.');
            return redirect()->back()->withInput();
        }
    }

    public function login()
    {
        $usuarioModel = new UsuarioModel();

        $correo = $this->request->getPost('correo_electronico');
        $password = $this->request->getPost('password');

        if (empty($correo) || empty($password)) {
            session()->setFlashdata('error', 'Por favor ingrese su correo y contraseña.');
            return redirect()->back();
        }

        $user = $usuarioModel->where('correo_electronico', $correo)->first();

        if ($user && password_verify($password, $user['password_hash'])) {
            $sessionData = [
                'id_usuario'         => $user['id_usuario'],
                'correo_electronico' => $user['correo_electronico'],
                'nombre'             => $user['nombre'],
                'apellido'           => $user['apellido'],
                'id_rol'             => $user['id_rol'],
                'logged_in'          => true
            ];
            session()->set($sessionData);

            session()->setFlashdata('success', '¡Bienvenido de vuelta, ' . esc($user['nombre']) . '!');

            if ($user['id_rol'] == 2) {
                return redirect()->to(base_url('admin/dashboard'));
            } else {
                return redirect()->to(base_url());
            }
        } else {
            session()->setFlashdata('error', 'Credenciales incorrectas. Verifique los datos ingresados.');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
