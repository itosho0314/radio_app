<?php
//session_start();
    echo "<body>\n";
//if(isset($_SESSION['name']))
//{
    
    echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
    echo '<font size="7">グラフページ</font>'."\n";
    echo "</div></p>";

    echo "<p style=".'"position:absolute;top:85px;left:30px;text-align: center;"'."><MARQUEE bgcolor='#e5f1ff' width='240' scrollamount='4'><FONT color= '#000099'>".$_SESSION['name']."でログイン中！"."</FONT></MARQUEE>";
    
    //ログアウトボタン
    echo $this->Form->create(null, [ "type" => "post","url" => [ "controller" => "Logout", "action" => "index" ] ] );
    echo '<p><input type="submit" name="bt" value="ログアウト" style=" width: 100px; height: 30px; position: relative; left: 20px; top: -30px"  />'."\n";
    echo $this->Form->end();
    
    //戻るボタン
    echo $this->Form->create(null, [ "type" => "post","url" => [ "controller" => "Top", "action" => "index" ] ] );
    echo '<p><input type="submit" name="bt" value="戻る" style=" width: 50px; height: 30px; position: absolute; left: 455px; top: 470px"  /p>'."\n";
    echo $this->Form->end();

    //時間のセレクト
    echo $this->Form->create(null, ["type" => "GET"]);
    echo $this->Form->select("minute",["1","5","10"],['default' => "5"]);

/*
    if(!isset($_GET['minute']))
    {
    echo '<option value = "1">1分</option>';
    echo '<option value = "5" selected>5分</option>';
    echo '<option value = "10">10分</option>';
    }
    if($_GET['minute']==1)
    {
        echo '<option value = "1" selected>1分</option>';
        echo '<option value = "5">5分</option>';
        echo '<option value = "10">10分</option>';
    }
    else if($_GET['minute']==5)
    {
        echo '<option value = "1">1分</option>';
        echo '<option value = "5" selected>5分</option>';
        echo '<option value = "10">10分</option>';
    }
    else if($_GET['minute']==10)
    {
        echo '<option value = "1">1分</option>';
        echo '<option value = "5">5分</option>';
        echo '<option value = "10" selected>10分</option>';
    }
    echo '</select>';
*/        
    if(isset($_GET['minute']))
    {
        $minute = $_GET['minute'];
    }
        
    //更新ボタン
    echo '<p><input type="submit" name="reload" value="更新" style=" width: 50px; height: 30px; position: absolute; left: 385px; top: 470px"  />'."\n";

    
    if(isset($_GET['reload']))
    {
        //ここから
        //画像を表示
        echo '<img src='.$file_path .' title="アンケート結果" style="position:absolute;top:160px;left:10px;">'."\n";
        echo'<p style='.'"position:absolute;top:115px;left:10px;"'.">"."アンケート結果". '</p>';            
        //ここまで　りろーで表示
        //echo $GETTT;
        var_dump($test);
        echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
        
    }
    
//}
/*
if(!isset($_SESSION["name"]))//不正にこのページに来たときログインページに飛ばす
{
     header("location: login_page.php");
     
}
*/

echo "</body>\n";
?>
