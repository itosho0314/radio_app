<?php
//おまじない　必ずつける
namespace App\Controller;
use App\Controller\AppController;

//class名はファイル名と合わせる
class LoginController extends AppController
{
    
    function index($loginError = NULL)
    {
        $login = 0;
        if($loginError == 1)
        {
            $login = 1;
        }

        if($loginError == 2)
        {
            $login = 2;
        }
        
        $this->set('login', $login);
    }
    
}
?>
