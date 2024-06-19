<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Usuario extends Entity {
  // protected $datamap = [];
  // protected $casts   = [];

  protected $dates   = ['criado_em', 'atualizado_em', 'deletado_em'];

  public function verificaPassword(string $password) {
    return password_verify($password, $this->password_hash);
  }
}
