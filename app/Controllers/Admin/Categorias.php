<?php

namespace App\Controllers\Admin;


use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\Categoria;

class Categorias extends BaseController{

    private $categoriaModel;

    public function __construct() {
        $this->categoriaModel = new \App\Models\CategoriaModel();
    }

    public function index(){
        $data = [
            'titulo' => 'Listando as categorias',
            'categorias' => $this->categoriaModel->withDeleted(true)->paginate(10),
            'pager' => $this->categoriaModel->pager,
        ];

        return view('Admin/Categorias/index', $data);
    }

    public function procurar() {

        if (!$this->request->isAJAX()) {
          exit('Pagina nao encontrada');
        };
    
        $categorias = $this->categoriaModel->procurar($this->request->getGet('term'));
        $retorno = [];
    
        foreach ($categorias as $categoria) {
          $data['id'] = $categoria->id;
          $data['value'] = $categoria->nome;
    
          $retorno[] = $data;
        }
    
        return $this->response->setJSON($retorno);
    
    }

    public function criar() {
        $categoria = new Categoria();
    
        $data = [
          'titulo' => "Cadastrando nova categoria",
          'categoria' => $categoria,
        ];
    
        return view('Admin/Categorias/criar', $data);
    }

    public function cadastrar() {
        if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
    
          $categoria = new Categoria($this->request->getPost());
    
          if($this->categoriaModel->save($categoria)) {
            return redirect()
              ->to(site_url('admin/categorias/show/'. $this->categoriaModel->getInsertID()))
              ->with('sucesso', 'categoria' . $categoria->nome . ' foi cadastrado com sucesso!');
    
          } else {
              return redirect()->back()
              ->with('errors_model', $this->categoriaModel->errors())
              ->with('atencao', 'Por favor verifique os erros abaixo')
              ->withInput();
          }
    
        } else {
          return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
        }
      }


    public function show($id = null) {
        $categoria = $this->buscaCategoriaOu404($id);
    
        $data = [
          'titulo' => "Detalhando a categoria {$categoria->nome}",
          'categoria' => $categoria,
        ];
    
        return view('Admin/Categorias/show', $data);
    }

    public function editar($id = null) {
        $categoria = $this->buscaCategoriaOu404($id);
    
        if($categoria->deletado_em != null){
          return redirect()->back()->with('info', "A categoria $categoria->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
        }
    
        $data = [
          'titulo' => "Editando a categoria {$categoria->nome}",
          'categoria' => $categoria,
        ];
    
        return view('Admin/Categorias/editar', $data);
    }

    public function atualizar($id = null) {
        if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
          $categoria = $this->buscaCategoriaOu404($id);
    
          if($categoria->deletado_em != null){
            return redirect()->back()->with('info', "A categoria $categoria->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
          }
          
          $post = $this->request->getPost();    
          $categoria->fill($post);
          // dd($categoria);
    
          if (!$categoria->hasChanged()) {
            return redirect()->back()->with('info', 'Não há dados para atualizar!');
          }
    
          if($this->categoriaModel->save($categoria)) {
            return redirect()
              ->to(site_url('admin/categorias/show/'.$categoria->id))
              ->with('sucesso', 'A categoria ' . $categoria->nome . ' foi atualizada com sucesso!');
    
          } else {
              return redirect()->back()
              ->with('errors_model', $this->categoriaModel->errors())
              ->with('atencao', 'Por favor verifique os erros abaixo')
              ->withInput();
          }
    
        } else {
          return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
        }
    }

    public function modalExcluir($id = null) {
        $categoria = $this->buscaCategoriaOu404($id);
    
        $data = [
          'titulo' => "Excluindo a categoria {$categoria->nome}",
          'categoria' => $categoria,
        ];
    
        return view('Admin/Categorias/excluir', $data);
    }
    
    public function excluir($id = null) {
        $categoria = $this->buscaCategoriaOu404($id);
    
        if($categoria->deletado_em != null){
          return redirect()->back()->with('info', "A categoria $categoria->nome já encontra-se excluida!");
        }
        
        if($categoria) {
          $this->categoriaModel->delete($id);
          return redirect()->to(site_url('admin/categorias'))->with('sucesso', "A categoria $categoria->nome foi excluída com sucesso!");
        }
    }

    public function desfazerExclusao($id = null) {
        $categoria = $this->buscaCategoriaOu404($id);
    
        if($categoria->deletado_em == null){
          return redirect()->back()->with('info', 'Apenas categorias excluidas podem ser recuperados!');
        }
    
        if($this->categoriaModel->desfazerExclusao($id)){
          return redirect()->back()->with('sucesso', 'Recuperação feita com sucesso');
        } else {
            return redirect()->back()
                ->with('errors_model', $this->categoriaModel->errors())
                ->with('atencao', 'Por favor verifique os erros abaixo')
                ->withInput();
        }
    }

    // @param id $id
    // @return objeto categoria
    private function buscaCategoriaOu404(int $id = null) {
        if (!$id || !$categoria = $this->categoriaModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException:: forPageNotFound("Não foi possível encontrar categoria $id");
        }

        return $categoria;
    }    
    
}
