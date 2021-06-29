<?php
//おまじない　必ずつける
namespace App\Controller;
use App\Controller\AppController;

//class名はファイル名と合わせる
class LogoutController extends AppController
{
    function index(){
        $session = $this->getRequest()->getSession();
        if(null == ($session->read('id'))){
            $loginError = 1;
            $this->redirect(['controller' => 'Login','action' =>'index',$loginError]);
        }else{

        $userName = $this ->users->get($session->read('id'))->username;
        $this -> set('name',$userName);
        $session->delete('id');
        $session->destroy();
        }
    }

}
?>
