<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\Extra;

class Extras extends BaseController{

    private $extraModel;    

    public function __construct() {
      $this->extraModel = new \App\Models\ExtraModel();
    }

    public function index(){
      $data = [
        'titulo' => 'Listando os extras',
        'extras' => $this->extraModel->withDeleted(true)->paginate(10),
        'pager' => $this->extraModel->pager,
      ];

      return view('Admin/Extras/index', $data);
    }

    public function criar() {
      $extra = new Extra();
  
      $data = [
        'titulo' => "Cadastrando nova extra",
        'extra' => $extra,
      ];
  
      return view('Admin/Extras/criar', $data);
    }
  
    public function cadastrar() {
      if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
  
        $extra = new Extra($this->request->getPost());
  
        if($this->extraModel->save($extra)) {
          return redirect()
            ->to(site_url('admin/extras/show/'. $this->extraModel->getInsertID()))
            ->with('sucesso', 'extra' . $extra->nome . ' foi cadastrado com sucesso!');
  
        } else {
            return redirect()->back()
            ->with('errors_model', $this->extraModel->errors())
            ->with('atencao', 'Por favor verifique os erros abaixo')
            ->withInput();
        }
  
      } else {
        return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
      }
    }

    public function procurar() {

      if (!$this->request->isAJAX()) {
        exit('Pagina nao encontrada');
      };
  
      $extras = $this->extraModel->procurar($this->request->getGet('term'));
      $retorno = [];
  
      foreach ($extras as $extra) {
        $data['id'] = $extra->id;
        $data['value'] = $extra->nome;
  
        $retorno[] = $data;
      }
  
      return $this->response->setJSON($retorno);    
    }

    public function show($id = null) {
      $extra = $this->buscaExtraOu404($id);
  
      $data = [
        'titulo' => "Detalhando o extra {$extra->nome}",
        'extra' => $extra,
      ];
  
      return view('Admin/extras/show', $data);
    }

    public function editar($id = null) {
      $extra = $this->buscaExtraOu404($id);
  
      if($extra->deletado_em != null){
        return redirect()->back()->with('info', "O extra $extra->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
      }
  
      $data = [
        'titulo' => "Editando o extra {$extra->nome}",
        'extra' => $extra,
      ];
  
      return view('Admin/Extras/editar', $data);
    }

    public function atualizar($id = null) {
      if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
        $extra = $this->buscaExtraOu404($id);
  
        if($extra->deletado_em != null){
          return redirect()->back()->with('info', "O extra $extra->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
        }
        
        $post = $this->request->getPost();    
        $extra->fill($post);
  
        if (!$extra->hasChanged()) {
          return redirect()->back()->with('info', 'Não há dados para atualizar!');
        }
  
        if($this->extraModel->save($extra)) {
          return redirect()
          ->to(site_url('admin/extras/show/'.$extra->id))
          ->with('sucesso', 'O extra ' . $extra->nome . ' foi atualizado com sucesso!');
  
        } else {
          return redirect()->back()
          ->with('errors_model', $this->extraModel->errors())
          ->with('atencao', 'Por favor verifique os erros abaixo')
          ->withInput();
        }
  
      } else {
        return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
      }
    }

    public function modalExcluir($id = null) {
      $extra = $this->buscaExtraOu404($id);
  
      $data = [
        'titulo' => "Excluindo o extra {$extra->nome}",
        'extra' => $extra,
      ];
  
      return view('Admin/Extras/excluir', $data);
    }

    public function excluir($id = null) {
      $extra = $this->buscaExtraOu404($id);
  
      if($extra->deletado_em != null){
        return redirect()->back()->with('info', "O extra $extra->nome já encontra-se excluido!");
      }
      
      if($extra) {
        $this->extraModel->delete($id);
        return redirect()->to(site_url('admin/extras'))->with('sucesso', "O extra $extra->nome foi excluído com sucesso!");
      }
    }
  
    public function desfazerExclusao($id = null) {
      $extra = $this->buscaExtraOu404($id);
  
      if($extra->deletado_em == null){
        return redirect()->back()->with('info', 'Apenas extras excluidas podem ser recuperados!');
      }
  
      if($this->extraModel->desfazerExclusao($id)){
        return redirect()->back()->with('sucesso', 'Recuperação feita com sucesso');
      } else {
          return redirect()->back()
              ->with('errors_model', $this->extraModel->errors())
              ->with('atencao', 'Por favor verifique os erros abaixo')
              ->withInput();
      }
    }

    private function buscaExtraOu404(int $id = null) {
      if (!$id || !$extra = $this->extraModel->withDeleted(true)->where('id', $id)->first()) {
          throw \CodeIgniter\Exceptions\PageNotFoundException:: forPageNotFound("Não foi possível encontrar o extra $id");
      }
  
      return $extra;
    }  

}
