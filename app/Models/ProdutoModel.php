<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model{

    protected $table            = 'produtos';
    protected $returnType       = 'App\Entities\Produto';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'categoria_id', 
        'nome', 
        'slug',
        'ativo',
        'imagem',
        'ingredientes',      
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'criado_em';
    protected $updatedField  = 'atualizado_em';
    protected $deletedField  = 'deletado_em';

    // Validation
    protected $validationRules = [
        'nome' => 'required|min_length[2]|is_unique[produtos.nome]|max_length[128]',
        'categoria_id' => 'required|integer',
        'ingredientes' => 'required|min_length[10]|max_length[1000]',
    ];

    protected $validationMessages = [
        'nome' => [
            'required' => 'O campo nome é obrigatorio',
            'is_unique' => 'Este produto já existe! Escolha outro nome.',
        ],

        'categoria_id' => [
            'required' => 'O campo categoria é obrigatorio',
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
