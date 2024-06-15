<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $allowedFields    = ['nome', 'email', 'cpf', 'telefone', ];
    protected $useSoftDeletes   = true;

    protected $useTimestamps        = true;
    protected $createdField         = 'criado_em'; 
    protected $updatedField         = 'atualizado_em';
    protected $deletedField         = 'deletado_em';

    protected $validationRules = [
        'nome'             => 'required|min_length[3]|alpha_numeric_space|max_length[128]',
        'email'            => 'required|max_length[254]|valid_email|is_unique[usuarios.email]',
        'cpf'              => 'required|exact_length[14]|is_unique[usuarios.cpf]',
        'password'         => 'required|max_length[255]|min_length[6]',
        'password_confirm' => 'required_with[password]|max_length[255]|matches[password]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'Este campo e obrigatorio',
        ],

        'email' => [
            'required' => 'Este campo e obrigatorio',
            'is_unique' => 'Desculpe, este email já existe. Por favor escolha outro.',
        ],

        'cpf' => [
            'required' => 'Este campo e obrigatorio',
            'is_unique' => 'Desculpe, este CPF já existe.',
        ],
    ];

    // Uso o contoller usuarios ataves do metodo autocomplete
    // @param string $term
    // @return array usuarios
    public function procurar($term) {
        if ($term === null) {
            return [];
        }

        return $this->select('id, nome')
                    ->like('nome', $term)
                    ->get()
                    ->getResult()
        ;
    }
}
