<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Login extends BaseController{
    public function novo(){
        
        $data = [
            'titulo' => 'Realize o login',
        ];

        return view('Login/novo', $data);
    }

    public function criar(){
        
        if($this->request->getPost()) {  //if($this->request->getMethod() === 'post') {  

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            // Recuperar a instancia do servico
            // $autenticacao = \Config\Services::autenticacao();
            $autenticacao = service('autenticacao');
      
            if($autenticacao->login($email, $password)){
                $usuario = $autenticacao->pegaUsuarioLogado();

                if(!$usuario->is_admin){
                    return redirect()->to(site_url('/')); 
                }

                return redirect()->to(site_url('admin/home'))->with('sucesso', "Ola $usuario->nome bem vindo de volta ao Food Delivery"); 

            } else {
                return redirect()->back()->with('Atenção', 'Não encontramos suas credenciais de acesso'); 
            }
      
        } else {
            return redirect()->back(); //aqui e onde se coloca o PAGE NOT FOUND
        }
    }

    public function logout(){

        service('autenticacao')->logout();
        return redirect()->to(site_url('login/mostraMensagemLogout'));        
        
    }

    public function mostraMensagemLogout(){
        return redirect()->to(site_url('login'))->with('sucesso', 'Voce foi deslogado com sucesso!');        
        
    }
}
