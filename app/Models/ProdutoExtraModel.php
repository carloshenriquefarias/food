<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoExtraModel extends Model{
    protected $table            = 'produtos_extras';
    protected $returnType       = 'object';
    protected $allowedFields    = ['produto_id', 'extras_id'];

    // Validation
    protected $validationRules = [
        'extra_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'extra_id' => [
            'required' => 'O campo extra é obrigatorio',
        ],
    ];

    // Recupera os extras do produto em questao
    public function buscaExtraDoProduto(int $produto_id = null) {
    
        return $this->select('extras.nome AS extra_nome, produtos_extras.*')
            ->join('extras', 'extras.id = produtos_extras.extra_id') 
            ->join('produtos', 'produtos.id = produtos_extras.produto_id') 
            ->where('produtos_extras.produto_id', $produto_id)
            ->findAll();
    }  
}
