<?php

    echo "<body>\n";  
    echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
    echo '<font size="7">グラフページ</font>'."\n";
    echo "</div></p>";

    echo "<p style=".'"position:absolute;top:85px;left:30px;text-align: center;"'."><MARQUEE bgcolor='#e5f1ff' width='240' scrollamount='4'><FONT color= '#000099'>".$name."でログイン中！"."</FONT></MARQUEE>";
    
    //ログアウトボタン
    echo $this->Form->create(null, [ "type" => "post","url" => [ "controller" => "Logout", "action" => "index" ] ] );
    echo '<p><input type="submit" name="bt" value="ログアウト" style=" width: 100px; height: 30px; position: absolute;top:80px;left:280px;"  />'."\n";
    echo $this->Form->end();
    
    //戻るボタン
    echo $this->Form->create(null, [ "type" => "post","url" => [ "controller" => "Top", "action" => "index" ] ] );
    echo '<p><input type="submit" name="bt" value="戻る" style=" width: 50px; height: 30px; position: absolute; left: 540px; top: 470px"  /p>'."\n";
    echo $this->Form->end();

    echo $this->Form->create(null, [ "type" => "post","url" => [ "controller" => "Top", "action" => "index" ] ] );
    echo '<p><input type="submit" name="bt" value="戻る" style=" width: 50px; height: 30px; position: absolute; left: 540px; top: 470px"  /p>'."\n";
    echo $this->Form->end();

    //時間のセレクト
    echo $this->Form->create(null, ["type" => "GET"]);
    echo "<p>".'<div style="width: 600px; height: 25px; text-align: center; 
                 position: relative; left: -110px; top: 30px;">'."<font size='3'>取得したい時間を入力してください</font>\n";
    echo $this->Form->input('minutes',array('type' => 'name' ,"size" => 10,'style'=> 'width: 60px; height: 25px;'));
    echo "<font size='3'> 分前</font></div></p>\n";
/*
    echo '<select name= "minutes" style=" width: 150px; height: 30px; position: absolute; left: 100px; top: 150px" id = "num">';

    echo '<option value ='.$min.' >'.$min. '</option> ';

    echo '<option value = "1">1分前</option>';

    echo '<option value = "5">5分前</option>';

    echo '<option value = "10">10分前</option>';

    echo '<option value = "15">15分前</option>';

    echo '<option value = "30">30分前</option>';

    echo '<option value = "60">60分前</option>';
    echo '</select>';
    /*
/*
    //何のグラフを作るかのセレクト
    echo '<select name= "mode" style=" width: 150px; height: 30px; position: absolute; left: 280px; top: 150px">';

    echo '<option value = "棒">棒グラフ</option>';

    echo '<option value = "円">円グラフ</option>';
    echo "</select>"; 
*/

    //更新ボタン    
    echo '<p><input type="submit" name="reload" value="更新" style=" width: 50px; height: 30px; position: absolute; left: 460px; top: 470px"  /></p>'."\n";
    echo $this->Form->end();

    if(isset($_GET['reload']))
    {

        //画像を表示
        //echo $this->Html->image('Imgdir/'.$file_name);
        echo '<img src=./img/Imgdir/'.$file_name.' title="アンケート結果" style="position:absolute;top:180px;left:10px;">'."\n";
        // echo'<p style='.'"position:absolute;top:200px;left:10px;"'.">"."アンケート結果". '</p>';            
               
    }
echo "</body>\n";
?>
