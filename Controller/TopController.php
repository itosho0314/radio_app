<?php
//おまじない　必ずつける
namespace App\Controller;
use App\Controller\AppController;
use App\Controller\LoginController;
//class名はファイル名と合わせる

class TopController extends AppController
{
    function index()
    {
        // テーブルの取得
        $usersTable = $this -> users;

        $userInfo = $usersTable -> find();
        $userInfo->enableHydration(false); // エンティティーの代わりに配列を返す
        $rows = $userInfo->toList(); // クエリーを実行し、配列を返す

        //var_dump($rows);

        // セッションオブジェクトの取得
        $session = $this->getRequest()->getSession();

        $flag = true;
        
        if(null == ($session->check('id')))
        {
            $flag = false;
            //var_dump($session->read('id'));
            for($i = 0;$i < count($rows);$i++)
            {
                if($this->getRequest()->getData('name')==($rows[$i]["username"]) && password_verify($this->getRequest()->getData('pass'),$rows[$i]['password']))
                {
                    $id = $rows[$i]["id"];
                    //var_dump($id);
                    //$rows[$session->read('id')-1]["username"];
                    //セッションにDBのIDを格納
                    $session->write("id",$id);
                    // var_dump($session->read('id'));
                    $flag = true;
                   
                    break;
                }
                
            }
        }

        if(null != ($session->check('id')))
        {
            $id = $session->read('id');
            $userName = $this ->users ->get($id)->username;
            $this -> set('name',$userName);
        }

        //ここにせっしょんないかつぽすとがないなら
        if(null == ($session->read('id'))&&null == $this->getRequest()->getData('name'))
        {
            $loginError = 1;
            $this->redirect(['controller' => 'Login','action' =>'index',$loginError]);
        }
        
        if($flag == false)
        {
            $loginError = 2;
            $this->redirect(['controller' => 'Login','action' =>'index',$loginError]);
        }
        
        $this->set('flag', $flag);
        
    }

}
?>
