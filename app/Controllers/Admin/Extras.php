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

    private function buscaExtraOu404(int $id = null) {
        if (!$id || !$extra = $this->extraModel->withDeleted(true)->where('id', $id)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException:: forPageNotFound("Não foi possível encontrar o extra $id");
        }
    
        return $extra;
    }  

}
