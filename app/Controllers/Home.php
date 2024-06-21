<?php

namespace App\Controllers;

class Home extends BaseController{

    public function index(): string{
        return view('welcome_message');
    }

    // public function email() {

    //     $email = service('email');
        
    //     $email->setFrom('your@example.com', 'Your Name');
    //     $email->setTo('petuniagray@navalcadets.com');
    //     // $email->setCC('another@another-example.com');
    //     // $email->setBCC('them@their-example.com');
        
    //     $email->setSubject('Teste de e-mail');
    //     $email->setMessage('Testing the email class.');
        
    //     if($email->send()){
    //         echo 'Email foi enviado';
    //     } else {
    //       echo $email->printDebugger();
    //     }
    // }
}
