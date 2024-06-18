<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\Usuario;

class Usuarios extends BaseController {
  private $usuarioModel;

  public function __construct() {
    $this->usuarioModel = new \App\Models\UsuarioModel();
  }

  public function index() {

    $data = [
      'titulo' => 'Listando os usuarios do sistema',
      'usuarios' => $this->usuarioModel->findAll(),
    ];

    // session()->remove('sucesso');

    return view('Admin/Usuarios/index', $data);
  }

  public function procurar() {

    if (!$this->request->isAJAX()) {
      exit('Pagina nao encontrada');
    };

    $usuarios = $this->usuarioModel->procurar($this->request->getGet('term'));
    $retorno = [];

    foreach ($usuarios as $usuario) {
      $data['id'] = $usuario->id;
      $data['value'] = $usuario->nome;

      $retorno[] = $data;
    }

    return $this->response->setJSON($retorno);

  }

  public function criar() {

    $usuario = new Usuario();

    $data = [
      'titulo' => "Criando um novo usuário",
      'usuario' => $usuario,
    ];

    return view('Admin/Usuarios/criar', $data);
  }

  public function cadastrar() {
    if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  

      $usuario = new Usuario($this->request->getPost());

      if($this->usuarioModel->protect(false)->save($usuario)) {
        return redirect()
          ->to(site_url('admin/usuarios/show/'. $this->usuarioModel->getInsertID()))
          ->with('sucesso', 'Usuario' . $usuario->nome . ' foi cadastrado com sucesso!');

      } else {
          return redirect()->back()
          ->with('errors_model', $this->usuarioModel->errors())
          ->with('atencao', 'Por favor verifique os erros abaixo')
          ->withInput();
      }

    } else {
      return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
    }
  }

  public function show($id = null) {
    $usuario = $this->buscaUsuarioOu404($id);

    $data = [
      'titulo' => "Detalhando o usuário {$usuario->nome}",
      'usuario' => $usuario,
    ];

    return view('Admin/Usuarios/show', $data);
  }

  public function editar($id = null) {
    $usuario = $this->buscaUsuarioOu404($id);

    $data = [
      'titulo' => "Editando o usuário {$usuario->nome}",
      'usuario' => $usuario,
    ];

    return view('Admin/Usuarios/editar', $data);
  }

  public function atualizar($id = null) {
    if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
      $usuario = $this->buscaUsuarioOu404($id);
      $post = $this->request->getPost();

      if(empty($post['password'])) {
        $this->usuarioModel->desabilitarValidacaoSenha();
        unset($post['password']);
        unset($post['password_confirmation']);
      }

      $usuario->fill($post);
      // dd($usuario);

      if (!$usuario->hasChanged()) {
        return redirect()->back()->with('info', 'Não há dados para atualizar!');
      }

      if($this->usuarioModel->protect(false)->save($usuario)) {
        return redirect()
          ->to(site_url('admin/usuarios/show/'.$usuario->id))
          ->with('sucesso', 'Os dados de ' . $usuario->nome . ' foram atualizados com sucesso!');

      } else {
          return redirect()->back()
          ->with('errors_model', $this->usuarioModel->errors())
          ->with('atencao', 'Por favor verifique os erros abaixo')
          ->withInput();
      }

    } else {
      return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
    }
  }


  // @param id $id
  // @return objeto usuario
  private function buscaUsuarioOu404(int $id = null) {
    if (!$id || !$usuario = $this->usuarioModel->where('id', $id)->first()) {
      throw \CodeIgniter\Exceptions\PageNotFoundException:: forPageNotFound("Não foi possível encontrar $id");
    }

    return $usuario;
  }    
}

