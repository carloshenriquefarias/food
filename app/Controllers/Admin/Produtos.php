<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Entities\Produto;

class Produtos extends BaseController{
    
    private $produtoModel;
    private $categoriaModel;
    private $extraModel;
    private $produtoExtraModel;

    public function __construct() {
      $this->produtoModel = new \App\Models\ProdutoModel();
      $this->categoriaModel = new \App\Models\CategoriaModel();
      $this->extraModel = new \App\Models\ExtraModel();
      $this->produtoExtraModel = new \App\Models\ProdutoExtraModel();
    }
  
    public function index(){
        $data = [
          'titulo' => 'Listando os produtos',
          'produtos' => $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
                                            ->join('categorias', 'categorias.id = produtos.categoria_id')
                                            ->withDeleted(true)
                                            ->paginate(10),
          'pager' => $this->produtoModel->pager,
        ];
  
      return view('Admin/Produtos/index', $data);
    }

    public function criar() {
      $produto = new Produto();
  
      $data = [
        'titulo' => "Cadastrando novo produto",
        'produto' => $produto,
        'categorias' => $this->categoriaModel->where('ativo', true)->findAll(),
      ];
  
      return view('Admin/Produtos/criar', $data);
    }
    
    public function cadastrar() {
        if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
    
          $produto = new Produto($this->request->getPost());
    
          if($this->produtoModel->save($produto)) {
            return redirect()
              ->to(site_url('admin/produtos/show/'. $this->produtoModel->getInsertID()))
              ->with('sucesso', "O produto $produto->nome foi cadastrado com sucesso!");
    
          } else {
              return redirect()->back()
              ->with('errors_model', $this->produtoModel->errors())
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
    
        $produtos = $this->produtoModel->procurar($this->request->getGet('term'));
        $retorno = [];
    
        foreach ($produtos as $produto) {
          $data['id'] = $produto->id;
          $data['value'] = $produto->nome;
    
          $retorno[] = $data;
        }
    
        return $this->response->setJSON($retorno);
      
    }

    public function show($id = null) {
        $produto = $this->buscaProdutoOu404($id);
    
        $data = [
          'titulo' => "Detalhando o produto {$produto->nome}",
          'produto' => $produto,
        ];
    
        return view('Admin/Produtos/show', $data);
    }

    public function editar($id = null) {
      $produto = $this->buscaProdutoOu404($id);
  
      if($produto->deletado_em != null){
        return redirect()->back()->with('info', "O produto $produto->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
      }
  
      $data = [
        'titulo' => "Editando o produto {$produto->nome}",
        'produto' => $produto,
        'categorias' => $this->categoriaModel->where('ativo', true)->findAll(), // para preencher o select do formulario
      ];
  
      return view('Admin/Produtos/editar', $data);
    }

    public function editarimagem($id = null) {
      $produto = $this->buscaProdutoOu404($id);
  
      if($produto->deletado_em != null){
        return redirect()->back()->with('info', "O produto $produto->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
      }
  
      $data = [
        'titulo' => "Editando a imagem do produto {$produto->nome}",
        'produto' => $produto,
      ];
  
      return view('Admin/Produtos/editar_imagem', $data);
    }

    public function upload($id = null) {
      $produto = $this->buscaProdutoOu404($id);
  
      $imagem = $this->request->getFile('foto_produto');
  
      if (!$imagem->isValid()) {
          $codigoErro = $imagem->getError();
          if ($codigoErro == UPLOAD_ERR_NO_FILE) {
              return redirect()->back()->with('atencao', 'Nenhum arquivo foi selecionado!');
          }
      }
  
      $tamanhoImagem = $imagem->getSizeByUnit('mb');
      if ($tamanhoImagem > 2) {
          return redirect()->back()->with('atencao', 'O tamanho desta imagem é muito grande! Escolha outra com até 2 MB.');
      }
  
      $tipoImagem = $imagem->getMimeType();
      $tipoImagemLimpo = explode('/', $tipoImagem);
      $tiposPermitidos = ['jpg', 'png', 'jpeg', 'webp'];
      if (!in_array($tipoImagemLimpo[1], $tiposPermitidos)) {
          return redirect()->back()->with('atencao', 'Este tipo de arquivo não é permitido! Escolha entre ' . implode(', ', $tiposPermitidos));
      }
  
      list($largura, $altura) = getimagesize($imagem->getPathName());
      if ($largura < 400 || $altura < 400) {
          return redirect()->back()->with('atencao', 'A imagem precisa ter no mínimo 400px de largura e 400px de altura!');
      }
  
      // Armazenando imagem e recuperando o caminho
      $imagemCaminho = $imagem->store('produtos');
      $imagemCaminho = WRITEPATH . 'uploads/' . $imagemCaminho;
  
      // Redimensionando a imagem
      service('image')->withFile($imagemCaminho)->fit(400, 400, 'center')->save($imagemCaminho);
  
      $imagemAntiga = $produto->imagem;
      $produto->imagem = $imagem->getName();
      $this->produtoModel->save($produto); // Salvando imagem
  
      // Deletando a imagem antiga
      $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagemAntiga;
      if (is_file($caminhoImagem) && !empty($imagemAntiga)) {
          unlink($caminhoImagem);
      }
  
      return redirect()
      ->to(site_url("admin/produtos/show/$produto->id"))
      ->with('sucesso', "A imagem do produto $produto->nome foi alterada com sucesso!");
    }

    public function imagem(string $imagem = null) {
      if($imagem){

        $caminhoImagem = WRITEPATH . 'uploads/produtos/' . $imagem;
        $infoImagem = new \finfo(FILEINFO_MIME);
        $tipoImagem = $infoImagem->file($caminhoImagem);

        header('Content-Type: '. $tipoImagem);
        header("Content-Length: ".filesize($caminhoImagem));

        readfile($caminhoImagem);

        exit;        
      }
    }

    public function atualizar($id = null) {
        if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  
          $produto = $this->buscaProdutoOu404($id);
    
          if($produto->deletado_em != null){
            return redirect()->back()->with('info', "O produto $produto->nome encontra-se excluido! Portanto, não e possivel edita-lo!");
          }
          
          $post = $this->request->getPost();    
          $produto->fill($post);
          // dd($produto);
    
          if (!$produto->hasChanged()) {
            return redirect()->back()->with('info', 'Não há dados para atualizar!');
          }
    
          if($this->produtoModel->save($produto)) {
            return redirect()
              ->to(site_url('admin/produtos/show/'.$produto->id))
              ->with('sucesso', 'O produto ' . $produto->nome . ' foi atualizado com sucesso!');
    
          } else {
              return redirect()->back()
              ->with('errors_model', $this->produtoModel->errors())
              ->with('atencao', 'Por favor verifique os erros abaixo')
              ->withInput();
          }
    
        } else {
          return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
        }
    }

    public function extras($id = null) {
      $produto = $this->buscaProdutoOu404($id);
  
      $data = [
          'titulo' => "Gerenciar os extras do produto {$produto->nome}",
          'produto' => $produto,
          'extras' => $this->extraModel->where('ativo', true)->findAll(),
          'produtosExtras' => $this->produtoExtraModel->buscaExtraDoProduto($produto->id), // Corrigido aqui
      ];
  
      return view('Admin/Produtos/extras', $data);
    }
  
    private function buscaProdutoOu404(int $id = null) {
        if (!$id || !$produto = $this->produtoModel->select('produtos.*, categorias.nome AS categoria')
            ->join('categorias', 'categorias.id = produtos.categoria_id')
            ->where('produtos.id', $id)
            ->withDeleted(true)->first()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException:: forPageNotFound("Não foi possível encontrar produto $id");
        }

        return $produto;
    }   
}
