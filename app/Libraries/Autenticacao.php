<?php

namespace App\Libraries;

class Autenticacao{
    private $usuario;

    //string $email, string $password, return boolean
    public function login(string $email, string $password){

        $usuarioModel = new \App\Models\UsuarioModel();
        $usuario = $usuarioModel->buscaUsuarioPorEmail($email);

        //Se nao encontrar o usuario por email, retorna false
        if($usuario === null){
            return false;
        }

        //Se a senha nao combinar com o password_hash, retorna false
        if(!$usuario->verificaPassword($password)){
            return false;
        }

        //Permitiremos apenas os usuarios ativos
        if(!$usuario->ativo){
            return false;
        }

        //Tudo certo, pode logar o usuario
        $this->logaUsuario($usuario);
        return true;
    }

    public function logout() {
        session()->destroy();
        return redirect()->to('/login');
    }    

    //Nao esquecer de compartilhar a instancia com o services
    public function pegaUsuarioLogado(){
        if($this->usuario === null){
            $this->usuario = $this->pegaUsuarioDaSessao();
        }

        //Retorna o usuario que foi definido no comeco da classe
        return $this->usuario;
    }

    public function estaLogado(){
        return $this->pegaUsuarioLogado() !== null;
    }

    private function pegaUsuarioDaSessao(){
        if(!session()->has('usuario_id')){
            return null;
        }

        $usuarioModel = new \App\Models\UsuarioModel();

        //Recupera o usuario de acordo com a chave da sessao do usuario_id
        $usuario = $usuarioModel->find(session()->get('usuario_id'));

        //Retorna o objeto usuario se o mesmo for encontrado e estiver ativo
        if($usuario && $usuario->ativo){
            return $usuario;
        }
    }

    private function logaUsuario(object $usuario){
        $session = session();
        $session->regenerate();
        $session->set('usuario_id', $usuario->id);
    }
}

