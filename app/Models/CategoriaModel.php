<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model{

    protected $table            = 'categorias';
    protected $returnType       = 'App\Entities\Categoria';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['nome', 'ativo', 'slug'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'nome'             => 'required|min_length[2]|alpha_numeric_space|is_unique[categorias.nome]|max_length[128]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatorio',
            'is_unique' => 'Esta cetegoria já existe! Escolha outro nome.',
        ],
    ];

    protected $beforeInsert = ['criaSlug'];
    protected $beforeUpdate = ['criaSlug'];

    protected function criaSlug(array $data) {
        if (isset($data['data']['nome'])) {
            $data['data']['slug'] = mb_url_title($data['data']['nome'], '-', true);
        }

        return $data;
    }

    // Uso o contoller categorias ataves do metodo autocomplete
    // @param string $term
    // @return array categorias
    public function procurar($term) {
        if ($term === null) {
            return [];
        }

        return $this->select('id, nome')
                    ->like('nome', $term)
                    ->withDeleted(true)
                    ->get()
                    ->getResult()
        ;
    }

    public function desfazerExclusao(int $id) {
        
        return $this->protect(false)
        ->where('id', $id)
        ->set('deletado_em', null)
        ->update();
    }

}
