<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model{
    protected $table            = 'usuarios';
    protected $returnType       = 'App\Entities\Usuario';
    protected $allowedFields    = ['nome', 'email', 'cpf', 'telefone', ];

    //Datas
    protected $useTimestamps        = true;
    protected $createdField         = 'criado_em'; 
    protected $updatedField         = 'atualizado_em';
    protected $dateFormat           = 'datetime'; // Para uso com o useSoftDeletes

    protected $useSoftDeletes       = true;
    protected $deletedField         = 'deletado_em';

    //Validacoes
    protected $validationRules = [
        'nome'             => 'required|min_length[3]|alpha_numeric_space|max_length[128]',
        'email'            => 'required|max_length[254]|valid_email|is_unique[usuarios.email]',
        'cpf'              => 'required|exact_length[14]|validaCpf|is_unique[usuarios.cpf]',
        'telefone'         => 'required',
        'password'         => 'required|max_length[255]|min_length[6]',
        'password_confirmation' => 'required_with[password]|max_length[255]|matches[password]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatorio',
        ],

        'email' => [
            'required' => 'O campo email é obrigatorio',
            'is_unique' => 'Desculpe, este email já existe. Por favor escolha outro.',
        ],

        'telefone' => [
            'required' => 'O campo telefone é obrigatorio',
        ],

        'cpf' => [
            'required' => 'O campo CPF é obrigatorio',
            'is_unique' => 'Desculpe, este CPF já existe.',
        ],
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data) {
        if (isset($data['data']['password'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);  // Remove o campo password original
            unset($data['data']['password_confirmation']);  // Remove o campo de confirmação
        }

        return $data;
    }
    

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

    public function desabilitarValidacaoSenha() {
        
        unset($this->validationRules['password']);
        unset($this->validationRules['password_confirmation']);
    }

    public function desfazerExclusao(int $id) {
        
        return $this->protect(false)
        ->where('id', $id)
        ->set('deletado_em', null)
        ->update();
    }

    //params string $email, return objeto $usuario
    public function buscaUsuarioPorEmail(string $email) {        
        return $this->where('email', $email)->first();
    }
}
