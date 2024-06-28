<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\Medida;

class Medidas extends BaseController{

    private $medidaModel;    

    public function __construct() {
      $this->medidaModel = new \App\Models\MedidaModel();
    }

    public function index(){
      $data = [
        'titulo' => 'Listando as medidas de produtos',
        'medidas' => $this->medidaModel->withDeleted(true)->paginate(10),
        'pager' => $this->medidaModel->pager,
      ];

      return view('Admin/Medidas/index', $data);
    }

    public function criar() {
        $medida = new Medida();
    
        $data = [
          'titulo' => "Cadastrando nova medida",
          'medida' => $medida,
        ];
    
        return view('Admin/Medidas/criar', $data);
    }
    
    public function cadastrar() {
        if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
    
          $medida = new Medida($this->request->getPost());
    
          if($this->medidaModel->save($medida)) {
            return redirect()
              ->to(site_url('admin/medidas/show/'. $this->medidaModel->getInsertID()))
              ->with('sucesso', "A medida' . $medida->nome . ' foi cadastrado com sucesso!");
    
          } else {
              return redirect()->back()
              ->with('errors_model', $this->medidaModel->errors())
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
    
        $medidas = $this->medidaModel->procurar($this->request->getGet('term'));
        $retorno = [];
    
        foreach ($medidas as $medida) {
          $data['id'] = $medida->id;
          $data['value'] = $medida->nome;
    
          $retorno[] = $data;
        }
    
        return $this->response->setJSON($retorno);    
    }
  
    public function show($id = null) {
        $medida = $this->buscaMedidaOu404($id);
    
        $data = [
          'titulo' => "Detalhando o medida {$medida->nome}",
          'medida' => $medida,
        ];
    
        return view('Admin/Medidas/show', $data);
    }

    public function editar($id = null) {
        $medida = $this->buscaMedidaOu404($id);
    
        if($medida->deletado_em != null){
          return redirect()->back()->with('info', "A medida $medida->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
        }
    
        $data = [
          'titulo' => "Editando o medida {$medida->nome}",
          'medida' => $medida,
        ];
    
        return view('Admin/Medidas/editar', $data);
    }
  
    public function atualizar($id = null) {
        if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
          $medida = $this->buscaMedidaOu404($id);
    
          if($medida->deletado_em != null){
            return redirect()->back()->with('info', "A medida $medida->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
          }
          
          $post = $this->request->getPost();    
          $medida->fill($post);
    
          if (!$medida->hasChanged()) {
            return redirect()->back()->with('info', 'Não há dados para atualizar!');
          }
    
          if($this->medidaModel->save($medida)) {
            return redirect()
            ->to(site_url('admin/medidas/show/'.$medida->id))
            ->with('sucesso', 'A medida ' . $medida->nome . ' foi atualizado com sucesso!');
    
          } else {
            return redirect()->back()
            ->with('errors_model', $this->medidaModel->errors())
            ->with('atencao', 'Por favor verifique os erros abaixo')
            ->withInput();
          }
    
        } else {
          return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
        }
    }

    public function modalExcluir($id = null) {
        $medida = $this->buscaMedidaOu404($id);
    
        $data = [
          'titulo' => "Excluindo o medida {$medida->nome}",
          'medida' => $medida,
        ];
    
        return view('Admin/Medidas/excluir', $data);
    }
  
    public function excluir($id = null) {
        $medida = $this->buscaMedidaOu404($id);
    
        if($medida->deletado_em != null){
          return redirect()->back()->with('info', "A medida $medida->nome já encontra-se excluido!");
        }
        
        if($medida) {
          $this->medidaModel->delete($id);
          return redirect()->to(site_url('admin/medidas'))->with('sucesso', "A medida $medida->nome foi excluído com sucesso!");
        }
    }
    
    public function desfazerExclusao($id = null) {
        $medida = $this->buscaMedidaOu404($id);
    
        if($medida->deletado_em == null){
          return redirect()->back()->with('info', 'Apenas medidas excluidas podem ser recuperados!');
        }
    
        if($this->medidaModel->desfazerExclusao($id)){
          return redirect()->back()->with('sucesso', 'Recuperação feita com sucesso');
        } else {
            return redirect()->back()
                ->with('errors_model', $this->medidaModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }

    private function buscaMedidaOu404(int $id = null) {
        if (!$id || !$medida = $this->medidaModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException:: forPageNotFound("Não foi possível encontrar a medida $id");
        }
    
        return $medida;
    }  
}
