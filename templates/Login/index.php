<?php
echo "<body>\n";

//echo "<center>\n";
echo '<table width="60%">'."\n";

if($login == 0)
{
    echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
    echo '<font size="7">ログインページ</font>'."\n";
    echo "</div></p>\n";
    
    echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Top","action"=>"index"]]);
    echo "<p>\n";
    echo '<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."\n";
    echo '<font size="3">ID</font></div>';
    echo $this->Form->input('name',array('type'=>'text','required'=>'true','style'=> 'width: 300px; height: 46px;'));
    echo "</p>\n";
    
    echo "<p>\n";
    echo '<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."\n";
    echo '<font size="3">パスワード</font></div>';
    echo $this->Form->input('pass',array('type'=>'password','required'=>'true','style'=> 'width: 300px; height: 46px;'));
    echo "</p>\n";
    
    echo $this->Form->input('bt',array('type'=>'submit','value'=>'ログイン','style'=> 'width: 100px; height: 30px;'));
    
    echo "<br />";
    echo "<br />";
    echo "<font size = '5'><a href="."Signup".">アカウントをお持ちでない方はこちら</a>";
}

if($login == 1)
{
    echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Top","action"=>"index"]]);

    echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
    echo '<font size="7">ログインページ</font>'."\n";
    echo "</div></p>";

    echo "<p><font size = '5'>ログインされていません。</font></p>\n";

    echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>ID</font>\n";
    echo $this->Form->input('name',array('type'=>'text','required'=>'true','style'=> 'width: 300px; height: 46px;'));

    echo "<p>".'<div style="width: 100px; height: 25px; border: 1px solid #333333; text-align: center;">'."<font size='3'>パスワード</font>\n";
    echo $this->Form->input('pass',array('type'=>'password','required'=>'true','style'=> 'width: 300px; height: 46px;'));

    echo $this->Form->input('bt',array('type'=>'submit','value'=>'ログイン','style'=> 'width: 100px; height: 30px;'));

    echo "<p style = ".'"position:absolute;top:350px;left:30px;"'."><font size = '5'><a href="."Signup".">アカウントをお持ちでない方はこちら</a>";

}

if($login == 2)
{
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
    
}

echo "</table>";
//echo "</center>";
echo "</form>\n";
echo "</body>\n";

?>
