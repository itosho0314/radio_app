<?php
echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
echo '<font size="7">新規登録ページ</font>'."\n";
echo "</div></p>\n";

echo $this->Form->create(null, [ "type" => "post","url" => [ "controller" => "SignupCheck", "action" => "index" ] ] );

//ID入力するやつ
echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>番組ID</font>\n";
echo $this->Form->input('name',array('type' => 'text',"size" => 10 ,'required' => 'true' ,'style'=> 'width: 300px; height: 46px;'));
echo "<p style=".'"position:absolute;top:90px;left:125px;text-align: center;"'."><FONT color= 'red'font size = '3'>※必須</FONT>\n";

//パスワード入力するやつ
echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>パスワード</font>\n";
echo $this->Form->input('pass',array('type' => 'password' ,"size" => 10,'required' => 'true' ,'style'=> 'width: 300px; height: 46px;'));
echo "<p style=".'"position:absolute;top:177px;left:125px;text-align: center;"'."><FONT color= 'red'font size = '3'>※必須</FONT>\n";

//tag入力するやつ
echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>#タグ</font>\n";
echo $this->Form->input('tag',array('type' => 'text' ,"size" => 10,'required' => 'true' ,'style'=> 'width: 300px; height: 46px;'));
echo "<p style=".'"position:absolute;top:262px;left:125px;text-align: center;"'."><FONT color= 'red'font size = '3'>※必須</FONT>\n";

//twitterID入力するやつ
echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>TwitterID</font>\n";
echo $this->Form->input('twitter',array('type' => 'text' ,"size" => 10,'required' => 'true' ,'style'=> 'width: 300px; height: 46px;'));
echo "<p style=".'"position:absolute;top:350px;left:125px;text-align: center;"'."><FONT color= 'red'font size = '3'>※必須</FONT>\n";


//API入力するやつ

echo "<p>".'<div style="position:absolute;top:499px;left:25px; width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>API key</font>\n";
echo $this->Form->input('api_key',array('type' => 'text' ,"size" => 10 ,'style'=> 'width: 300px; height: 46px;'));
echo "</div>";
echo "<p style=".'"position:absolute;top:449px;left:25px;"'."><FONT font size = '4'>以降、リプライ、DMを取得するのに必要になります。(任意)</FONT>\n";

//APIパスワード入力するやつ
echo "<p>".'<div style="position:absolute;top:587px;left:25px; width: 150px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>API key secret</font>\n";
echo $this->Form->input('api_seckey',array('type' => 'text' ,"size" => 10,'style'=> 'width: 300px; height: 46px;'));
echo "</div>";

//Access token入力するやつ
echo "<p>".'<div style="position:absolute;top:675px;left:25px; width: 150px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>Access token</font>\n";
echo $this->Form->input('access_token',array('type' => 'text' ,"size" => 10,'style'=> 'width: 300px; height: 46px;'));
echo "</div>";

//Access tokenパスワード入力するやつ
echo "<p>".'<div style="position:absolute;top:763px;left:25px; width: 200px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>Access token secret</font>\n";
echo $this->Form->input('access_sectoken',array('type' => 'text' ,"size" => 10,'style'=> 'width: 300px; height: 46px;'));
echo "</div>";

//登録ボタン
echo '<p><input type="submit" name="bt" value="登録" style=" width: 100px; height: 30px; position: relative; left: 170px; top: 415px"  />'."\n";
echo $this->Form->end();


//戻るボタン
//echo $this->Form->postButton('戻る', ['type' => 'post', "url" => [ "controller" => "Login", "action" => "index" ]]);

echo $this->Form->create(null, [ "type" => "post","url" => [ "controller" => "Login", "action" => "index" ] ] );
echo '<p><input type="submit" name="bt" value="戻る" style=" width: 100px; height: 30px; position: relative; left: 20px; top: 370px"  />'."\n";
echo $this->Form->end();


echo "</body>\n";
?>
