<?php
//おまじない　必ずつける
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

//class名はファイル名と合わせる
class SignupCheckController extends AppController
{

    function index(){

        $usersTable = $this ->users;
       
        $infosTable = $this ->twitterinfos;
       
        $user = $usersTable->newEmptyEntity();
        $info = $infosTable->newEmptyEntity();

        $user->username = $this->getRequest()->getData('name');
        $user->password = password_hash($this->getRequest()->getData('pass'), PASSWORD_DEFAULT);
        
        if ($usersTable->save($user)) {
            $id = $user->id;
        }

        $hashtag = $this ->check_tag($this->getRequest()->getData('tag'));
        
        $info->hashtag = $hashtag; 


        $twitter_id = $this ->check_twitterID($this->getRequest()->getData('twitter'));
        $info->twitter_id = $twitter_id;
        
        $info->api_key = $this->getRequest()->getData('api_key');
        $info->api_seckey = $this->getRequest()->getData('api_seckey');
        $info->access_token = $this->getRequest()->getData('access_token');
        $info->access_sectoken = $this->getRequest()->getData('access_sectoken');


        if ($infosTable->save($info)) {
            $id = $info->id;
        }
    }
    //入力された#タグを正しい文字列に修正
    function check_tag($str){
        $s_str = mb_convert_kana($str, 'a');
        if(substr($s_str,0,1) !== '#'){
            $tag = '#'.$str;
        }
        else{
            $tag = $str;
            $tag = str_replace('＃','#',$str);
        }
        return $tag;
    }

    //入力されたtwitterIDを正しい文字列に修正
    function check_twitterID($str){
        $s_str = mb_convert_kana($str, 'a');
        if(substr($s_str,0,1) !== '@'){ 
            $id = '@'.$str;
        }else{
            $id = $str;
            $id = str_replace('＠','@',$str);
        }
        return $id;
    }

}
?>
