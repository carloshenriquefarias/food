<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController {
  public function index() {
    $data = [
      'titulo' => 'Home da area restrita',
    ];

    return view('Admin/Home/index', $data);
    // return view('welcome_message', $data);
  }
}
