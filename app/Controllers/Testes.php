<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Testes extends BaseController {
  public function index() {

    $data = [
      'titulo' => 'Como fazer um sistema de comida',
      'subtitulo' => 'Muito massa',
    ];

    return view('Testes/index', $data);
    // return view('welcome_message');
  }

  public function novo() {
    echo 'Esta e mais um metodo do controller testes';
  }
}
