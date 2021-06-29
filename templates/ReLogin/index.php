<?php
echo "<!DOCTYPE html>\n";
echo "<html lang=".'"ja"'.">\n";
echo "<head>\n";
echo "<meta http-equiv=".'"Content-Type"'." content=".'"text/html; charset=UTF-8"'.">\n";
echo "<title>再ログイン</title>\n";
echo "</head>\n";

echo "<body>\n";

echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Top","action"=>"index"]]);

echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
echo '<font size="7">再ログインページ</font>'."\n";
echo "</div></p>";

echo "<p><font size = '5'>ログインできませんでした。</font></p>\n";

echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>ID</font>\n";
echo $this->Form->input('name',array('type'=>'text','required'=>'true','style'=> 'width: 300px; height: 46px;'));

echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>パスワード</font>\n";
echo $this->Form->input('pass',array('type'=>'password','required'=>'true','style'=> 'width: 300px; height: 46px;'));

echo $this->Form->input('bt',array('type'=>'submit','value'=>'ログイン','style'=> 'width: 100px; height: 30px;'));

echo "<p style = ".'"position:absolute;top:350px;left:30px;"'."><font size = '5'><a href="."Signup".">アカウントをお持ちでない方はこちら</a>";

echo "</form>\n";

echo "</form>\n";
echo "</body>\n";

echo "</html>\n";

?>
