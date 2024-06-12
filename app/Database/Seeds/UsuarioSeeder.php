<?php

namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class UsuarioSeeder extends Seeder {
    public function run() {
        $usuarioModel = new \App\Models\UsuarioModel;

        $usuario = [
            'nome' => 'Wilson',
            'email' => 'wilson@example.com',
            'cpf' => '048.695.870-12',
            'telefone' => '86 - 99999999',
        ];

        $usuarioModel->protect(false)->insert($usuario);

        $usuario = [
            'nome' => 'Boris',
            'email' => 'boris@email.com',
            'cpf' => '968.256.650-95',
            'telefone' => '86 - 88888888',
        ];

        $usuarioModel->protect(false)->insert($usuario);

        $errors = $usuarioModel->errors();
        if (!empty($errors)) {
            dd($errors);
        }
    }
}