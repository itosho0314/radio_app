<?php

$session = $this->getRequest()->getSession();

echo "<body>\n";

$conn = "dbname=ensyu user=ensyu password=min7a7akay0shi";
$link = pg_connect($conn);
if(!$link)
{
    die('接続失敗です。'.pg_last_error());
}

$result = pg_query('SELECT * FROM customer_information_tags');//変更
if(!$result)
{
    die('クエリーが失敗しました。'.pg_last_error());
}

for ($i = 0; $i < pg_num_rows($result); $i++)
{
    $rows = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    //    echo $rows["program"];
    if(($session->read('name')) == ($rows['program']))
    {
        $password = $rows["password"];
        $hashtag = $rows["hashtag"];
        $twitterid = $rows["twitterid"];
        //  echo "bbbbbbbbbbb";
        break;
    }
}

if (null!=($session->read('name')))
{
    echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
    echo '<font size="7">設定ページ</font>'."\n";
    echo "</div></p>";

    echo "<p style=".'"position:absolute;top:85px;left:30px;text-align: center;"'."><MARQUEE bgcolor='#e5f1ff' width='240' scrollamount='4'><FONT color= '#000099'>".$session->read('name')."でログイン中！"."</FONT></MARQUEE>";

//現在の#タグ、twitterIDを表示
    if(null!=($this->getRequest()->getData('newtext')))
    {
        //echo $hashtag;
        echo "<p style=".'"position:absolute;top:120px;left:10px; background-color:#cccccc; width: 350px; height: 90px; text-align: center;"'."><font size='5'><b>現在の設定</font><br /><font size='4'>#タグ:".$hashtag."<br />twitterID:".$twitterid."</b></font>";
    }
    else if(substr($this->getRequest()->getData('newtext'),0,1)=="#")//#のとき
    {
        echo "<p style=".'"position:absolute;top:120px;left:10px; background-color:#cccccc; width: 350px; height: 90px; text-align: center;"'."><font size='5'><b>現在の設定</font><br /><font size='4'>#タグ:".$this->getRequest()->getData('newtext')."<br />twitterID:".$twitterid."</b></font>";
    }
    else if(substr($this->getRequest()->getData('twitter'),0,1)=="@")//@のとき
    {
        echo "<p style=".'"position:absolute;top:120px;left:10px; background-color:#cccccc; width: 350px; height: 90px; text-align: center;"'."><font size='5'><b>現在の設定</font><br /><font size='4'>#タグ:".$hashtag."<br />twitterID:".$this->getRequest()->getData('newtext')."</b></font>";
    }
    else
    {
        echo "<p style=".'"position:absolute;top:120px;left:10px; background-color:#cccccc; width: 350px; height: 90px; text-align: center;"'."><font size='5'><b>現在の設定</font><br /><font size='4'>#タグ:".$hashtag."<br />twitterID:".$twitterid."</b></font>";
    }

//データベース変更用のテキストボックス
    echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Config","action"=>"index"]]);
    //    echo '<form action= "./configu_page.php" method ="POST">'."\n";
    echo '<input type= "text" name= "newtext" style= "width: 350px; height: 46px; position: absolute; left: 10px; top: 340px">';

    //何を変更するかのセレクトボックス
    echo '<select name= "what" style=" width: 75px; height: 30px; position: absolute; left: 150px; top: 250px">';
    echo '<option value = "1">#タグ</option>';
    echo '<option value = "2">twitterID</option>';

    //変更ボタン
    echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Config","action"=>"index"]]);
    echo '<p><input type="submit" name="change" value="変更" style=" width: 50px; height: 30px; position: absolute; left: 70px; top: 480px"  /p>'."\n";
    echo $this->Form->end();
    
    //このアカウントを削除ボタン
    echo '<p><input type="submit" name="delete" value="このアカウントを削除" style=" width: 190px; height: 30px; position: absolute; left: 60px; top: 530px"  /p>'."\n";
    echo $this->Form->end();
    //    echo "</form>\n";

 //ログアウトボタン
    echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Logout","action"=>"index"]]);
    //    echo "<form method=".'"POST"'."action=".'"logout_page.php"'.">\n";
    echo "<p><center><input type=".'"submit"'."value=".'"ログアウト"'."style = ".'"position:absolute;top:100px;left:315px;"'."></center></p>\n";
    echo $this->Form->end();
    //    echo "</form>\n";

    //戻るボタン
    echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Top","action"=>"index"]]);
    //    echo "<form method=".'"POST"'."action=".'"top_page.php"'.">\n";
    echo '<p><input type="submit" name="bt" value="戻る" style=" width: 50px; height: 30px; position: absolute; left: 180px; top: 480px"  /p>'."\n";
    echo $this->Form->end();
    //    echo "</form>\n";

    //テキスト
    echo '<p style="position:absolute;top:340px;left:10px;"><font size="3">変更したい設定</font></p>';
    echo '<p style="position:absolute;top:390px;left:10px;"><font size="3">新しい設定</font></p>';
    echo '<p style="position:absolute;top:390px;left:110px;text-align: center;"><FONT color= "red"font size = "3">先頭に#か@をつけて入力してください。</FONT></p>';

//変更ボタンが押されたとき
    if(null!=(($this->getRequest()->getData('change'))&&($this->getRequest()->getData('newtext'))!=null))
    {
        echo 'aaaa';
        if(substr($this->getRequest()->getData('newtext'),0,1)=="#"&&($this->getRequest()->getData('what')==1))//#タグの変更
        {
            //echo '<p style="position:absolute;top:240px;left:10px;"><font size="5">新しいaaa'.$_POST['newtext'].'</font></p>';
            $sql = "UPDATE customer_information_tags SET hashtag = '".$this->getRequest()->getData('newtext')."' WHERE id = '".$session->read('name')."'";
            $res = pg_query($link,$sql);
            ver_dump(pg_result_status($res));
        }
        if(substr($this->getRequest()->getData('newtext'),0,1)=="@"||($this->getRequest()->getData('what')==2))//twitterIDの変更
        {
            //echo '<p style="position:absolute;top:240px;left:10px;"><font size="5">新しいbbb'.$_POST['newtext'].'</font></p>';
            $sql = "UPDATE customer_information_tags SET twitterid = '".$this->getRequest()->getData('newtext')."' WHERE id = '".$session->read('name')."'";
            $res = pg_query($link,$sql);
            ver_dump(pg_result_status($res));
        }
    }
    if(null!=($this->getRequest()->getData('delate')))
    {
        $sql = "DELETE FROM customer_information_tags WHERE program = '".$session->read('name')."'";
        $res = pg_query($link,$sql);
        if (!$res)
        {
            die('INSERTクエリーが失敗しました。'.pg_last_error());
        }
        $_SESSION = array();
        session_destroy();
        header("location: Login");
    }
}

if(null==($session->read('name')))//不正にこのページに来たときログインページに飛ばす
{
     header("location: Login");
}

$close_flag = pg_close($link);
if(!$close_flag)
{
    print('切断に失敗しました。<br>');
}

//echo "</body>\n";
?>
