<?php
//おまじない　必ずつける
namespace App\Controller;
use App\Controller\AppController;

//class名はファイル名と合わせる
class ConfigController extends AppController
{
    function index()
    {
        $session = $this->getRequest()->getSession();
        $id = $session->read('id');

        $change = ($this->getRequest()->getData('change'));
        $textbox = ($this->getRequest()->getData('textbox'));
        $this->set('flagPass',false);
        $textJudge = true;
            
        if(null!=($session->read('id')))
        {
            // テーブルの取得
            $usersTable = $this -> users;        
            $usersInfo = $usersTable -> find();
            $rows = $usersInfo->toList(); // クエリーを実行し、配列を返す
            
            //テーブルの取得
            $twittersTable = $this -> twitterinfos;
            $twittersInfo = $twittersTable -> find();
            $rows2 = $twittersInfo->toList(); // クエリーを実行し、配列を返す
            
            for ($i = 0; $i < count($rows); $i++)
            {
                if(($session->read('id')) == ($rows[$i]['id']))
                {
                    $password = $rows[$i]["password"];
                    
                    break;
                }
            }
            
            for ($i = 0; $i < count($rows2); $i++)
            {    
                if(($session->read('id')) == ($rows2[$i]['id']))
                { 
                    $hashtag = $rows2[$i]["hashtag"]; 
                    $twitterid = $rows2[$i]["twitter_id"];
                    $api_key = $rows2[$i]["api_key"];
                    $api_pass = $rows2[$i]["api_seckey"];
                    $access_token = $rows2[$i]["access_token"];
                    $access_token_pass = $rows2[$i]["access_sectoken"];
                    
                    break;
                }
            }
            
            //ログイン名を表示
            $userName = $this ->users ->get($id)->username;
            $this -> set('loginName',$userName);

            //現在のハッシュタグとtwitterIDを表示
            $this->set('hashtag',$hashtag);
            $this->set('twitterid',$twitterid);
            $this->set('api_key',$api_key);
            $this->set('api_pass',$api_pass);
            $this->set('access_token',$access_token);
            $this->set('access_token_pass',$access_token_pass);

            //データベース変更用のテキストボックス
            //何を変更するかのセレクトボックス
            //変更ボタン
            //このアカウントを削除ボタン
            //ログアウトボタン
            //戻るボタン
            //テキスト(変更したいテ設定、新しい設定、先頭に#か@をつけてください)
            
            //変更ボタンが押されてテキストボックスに文字が入ってたとき            
            if(null!=($this->getRequest()->getData('change'))&&null!=($this->getRequest()->getData('newtext')))
            {
                if(mb_substr($this->getRequest()->getData('newtext'),0,1)=="#"&&($this->getRequest()->getData('what')==1))//#タグの変更
                {
                    //テーブルを持ってきて行を指定
                    $entity = $twittersTable -> get($session->read('id'));
                    //変更
                    $entity -> hashtag = $this->getRequest()->getData('newtext');
                    //保存
                    $this->twitterinfos -> save($entity);

                    //新しいハッシュタグと現在のtwitterID、API系を表示
                    $this->set('hashtag',$this->getRequest()->getData('newtext'));
                    $this->set('twitterid',$twitterid);
                    $this->set('api_key',$api_key);
                    $this->set('api_pass',$api_pass);
                    $this->set('access_token',$access_token);
                    $this->set('access_token_pass',$access_token_pass);
                }
                
                else if(substr($this->getRequest()->getData('newtext'),0,1)=="@"&&($this->getRequest()->getData('what')==2))//twitterIDの変更
                {
                    //テーブル持ってきて、行を指定
                    $entity = $twittersTable -> get($session->read('id'));
                    //変更
                    $entity -> twitterid = $this->getRequest()->getData('newtext');
                    //保存
                    $this->twitterinfos -> save($entity);

                    //現在のハッシュタグと新しいtwitterID、現在のAPI系を表示
                    $this->set('hashtag',$hashtag);
                    $this->set('twitterid',$this->getRequest()->getData('newtext'));
                    $this->set('api_key',$api_key);
                    $this->set('api_pass',$api_pass);
                    $this->set('access_token',$access_token);
                    $this->set('access_token_pass',$access_token_pass);
                }

                else if($this->getRequest()->getData('what')==3)//APIkeyの変更
                {
                    //テーブル持ってきて、行を指定
                    $entity = $twittersTable -> get($session->read('id'));
                    //変更
                    $entity -> apikey = $this->getRequest()->getData('newtext');
                    //保存
                    $this->twitterinfos-> save($entity);

                    //現在のハッシュタグとtwitterID、API系を表示
                    $this->set('hashtag',$hashtag);
                    $this->set('twitterid',$twitterid);
                    $this->set('api_key',$this->getRequest()->getData('newtext'));
                    $this->set('api_pass',$api_pass);
                    $this->set('access_token',$access_token);
                    $this->set('access_token_pass',$access_token_pass);
                }

                else if($this->getRequest()->getData('what')==4)//APIpassの変更
                {
                    //テーブル持ってきて、行を指定
                    $entity = $twittersTable -> get($session->read('id'));
                    //変更
                    $entity -> apisecretkey = $this->getRequest()->getData('newtext');
                    //保存
                    $this->twitterinfos-> save($entity);

                    //現在のハッシュタグとtwitterID,API系を表示
                    $this->set('hashtag',$hashtag);
                    $this->set('twitterid',$twitterid);
                    $this->set('api_key',$api_key);
                    $this->set('api_pass',$this->getRequest()->getData('newtext'));
                    $this->set('access_token',$access_token);
                    $this->set('access_token_pass',$access_token_pass);
                }

                else if($this->getRequest()->getData('what')==5)//accesstokenの変更
                {
                    //テーブル持ってきて、行を指定
                    $entity = $twittersTable -> get($session->read('id'));
                    //変更
                    $entity -> accesstoken = $this->getRequest()->getData('newtext');
                    //保存
                    $this->$twitterinfos -> save($entity);

                    //現在のハッシュタグと新しいtwitterID、現在のAPI系を表示
                    $this->set('hashtag',$hashtag);
                    $this->set('twitterid',$twitterid);
                    $this->set('api_key',$api_key);
                    $this->set('api_pass',$api_pass);
                    $this->set('access_token',$this->getRequest()->getData('newtext'));
                    $this->set('access_token_pass',$access_token_pass);
                }

                else if($this->getRequest()->getData('what')==6)//accesssecrettokenの変更
                {
                    //テーブル持ってきて、行を指定
                    $entity = $twittersTable -> get($session->read('id'));
                    //変更
                    $entity -> accesssecrettoken = $this->getRequest()->getData('newtext');
                    //保存
                    $this->twitterinfos -> save($entity);

                    //現在のハッシュタグとtwitterID,API系を表示
                    $this->set('hashtag',$hashtag);
                    $this->set('twitterid',$twitterid);
                    $this->set('api_key',$api_key);
                    $this->set('api_pass',$api_pass);
                    $this->set('access_token',$access_token);
                    $this->set('access_token_pass',$this->getRequest()->getData('newtext'));
                }

                else if($this->getRequest()->getData('what')==7)//パスワードの変更
                {
                    $this->set('flagPass',true);//再入力フォームの出現
                    //newtextの保存をここでする。たぶんセッションに入れる。ダメだったらハッシュを壊して登録
                }

                else
                {
                    $textJudge = false;
                }
            }

            //変更ボタンが押されて再確認テキストボックスに文字が入ってたとき
            if(null!=($this->getRequest()->getData('reChange'))&&null!=($this->getRequest()->getData('rePass')))
            {
                //echo "aaaaaaaaaaaaaaaaaa";
                //一回目のパスワードと二回目のパスワードが一致したら
                if($this->getRequest()->getData('rePass') == ($this->getRequest()->getData('newtext')))
                    {
                        //echo "bbbbbbbbbbbbbbbbbbbbbb";
                        //テーブル持ってきて、行を指定
                        $entity = $usersTable -> get($session->read('id'));

                        //変更
                        $entity -> password = password_hash($this->getRequest()->getData('rePass'), PASSWORD_DEFAULT);
                        //ここでnewtextのセッションをデリートする
                    }
            }
            
            //api設定ボタンが押されたとき
            if(null!=($this->getRequest()->getData('apiConfig')))
            {
                $this->set('flag',true);
            }
            else
            {
                $this->set('flag',false);
            }

            //api設定閉じるボタンが押されたとき
            if(null!=($this->getRequest()->getData('apiConfigClose')))
            {
                $this->set('flag',false);
            }
            
            
            //削除ボタンが押されたとき
            if(null!=($this->getRequest()->getData('delete')))
            {
                //テーブル持ってきて、行を指定
                $entity = $usersTable -> get($session->read('id'));
                //削除
                $this->users->delete($entity);

                //テーブル持ってきて、行を指定
                //                $entity = $usersTable -> get($session->read('id'));
                //削除
                $this->twitterinfos->delete($entity);
                
                $session->destroy();
                $this->redirect('/Login');
            }
        }

        $this->set('textJudge',$textJudge);
        
        if(null==($session->read('id')))//不正にこのページに来たときログインコントローラに飛ばす
        {
            $loginError = 1;
            $this->redirect(['controller' => 'Login','action' =>'index',$loginError]);
        }
        
    }
}
?>
