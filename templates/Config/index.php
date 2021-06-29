<?php

echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";

echo '<font size="7">設定ページ</font>'."\n";

echo "</div></p>";

//ログイン名の表示
echo "<p style=".'"position:absolute;top:85px;left:30px;text-align: center;"'."><MARQUEE bgcolor='#e5f1ff' width='240' scrollamount='4'><FONT color= '#000099'>".$loginName."でログイン中！"."</FONT></MARQUEE>";

//現在(変更後)の#タグ、twitterIDを表示
echo "<p style=".'"position:absolute;top:120px;left:10px; background-color:#cccccc; width: 350px; height: 90px; text-align: center;"'."><font size='5'><b>現在の設定</font><br /><font size='4'>#タグ:".$hashtag."<br />twitterID:".$twitterid."</b></font>";

//フォームを設定(configにpost)
echo $this->Form->create(null,["type"=> "POST"]);

//データベース変更用のテキストボックス
echo $this->Form->input('newtext',array('type'=>'text','style'=> 'width: 350px; height: 46px; position: absolute; left: 10px; top: 340px'));

//何を変更するかのセレクトボックス
echo '<select name= "what" style=" width: 200px; height: 30px; position: absolute; left: 150px; top: 250px">';

echo '<option value = "1">#タグ</option>';

echo '<option value = "2">twitterID</option>';

echo '<option value = "3">API key</option>';

echo '<option value = "4">APIパス</option>';

echo '<option value = "5">Access Token</option>';

echo '<option value = "6">Access Tokenパス</option>';

echo '<option value = "7">パスワード</option>';

//APIの設定見るボタン
echo '<p><input type="submit" name="apiConfig" value="API関連の設定を見る" style=" width: 150px; height: 30px; position: absolute; left: 370px; top: 120px"  /p>'."\n";

//変更ボタン
echo '<p><input type="submit" name="change" value="変更" style=" width: 50px; height: 30px; position: absolute; left: 70px; top: 410px"  /p>'."\n";

//このアカウントを削除ボタン
echo '<p><input type="submit" name="delete" value="このアカウントを削除" style=" width: 190px; height: 30px; position: absolute; left: 60px; top: 460px"  /p>'."\n";

//フォーム解除
echo $this->Form->end();

//フォームを設定(logoutにpost)
echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Logout","action"=>"index"]]);

//ログアウトボタン
echo "<p><center><input type=".'"submit"'."value=".'"ログアウト"'."style = ".'"position:absolute;top:80px;left:280px;"'."></center></p>\n";

//フォーム解除
echo $this->Form->end();

//フォームを設定(topにpost)
echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Top","action"=>"index"]]);

//戻るボタン
echo '<p><input type="submit" name="bt" value="戻る" style=" width: 50px; height: 30px; position: absolute; left: 180px; top: 410px"  /p>'."\n";

//フォーム解除
echo $this->Form->end();

//テキスト
echo '<p style="position:absolute;top:250px;left:10px;"><font size="3">変更したい設定</font></p>';

echo '<p style="position:absolute;top:300px;left:10px;"><font size="3">新しい設定</font></p>';

echo '<p style="position:absolute;top:300px;left:110px;text-align: center;"><FONT color= "red"font size = "3">先頭に#か@をつけて入力してください。</FONT></p>';

if($textJudge == false)
{
    echo '<p style="position:absolute;top:220px;left:10px;text-align: center;"><FONT color= "red"font size = "3">入力された文字が正しくありません。</FONT></p>';
}

//API設定のフラグ
if($flag == true)
{
    //設定表示
    echo "<p style=".'"position:absolute;top:150px;left:370px; background-color:#cccccc; width: 600px; height: 300px; text-align: center;"'."><font size='5'><b>現在の設定</font><br /><font size='4'>API key:<br />".$api_key."<br />APIパス:<br />".$api_pass."<br />Access Token:<br />".$access_token."<br />Access Tokenパス:<br />".$access_token_pass."</b></font>";

    //フォームを設定(configにpost)
    echo $this->Form->create(null,["type"=> "POST"]);
    
    //APIの設定消すボタン
    echo '<p><input type="submit" name="apiConfigClose" value="API関連の設定を閉じる" style=" width: 160px; height: 30px; position: absolute; left: 530px; top: 120px"  /p>'."\n";

    //フォーム解除
    echo $this->Form->end();
}

//パスワード変更のフラグ
if($flagPass == true)
{
    //白背景
    echo "<p style=".'"position:absolute;top:220px;left:10px; background-color:#ffffff; width: 400px; height: 300px; text-align: center;"'.">";

    //テキスト
    echo '<p style="position:absolute;top:250px;left:10px;"><font size="3">確認のためもう一度入力してください</font></p>';
    echo '<p style="position:absolute;top:300px;left:10px;"><font size="3">新しいパスワード</font></p>';

    //フォームを設定(configにpost)
    echo $this->Form->create(null,["type"=> "POST"]);
    
    //パスワード再入力用のテキストボックス
    echo $this->Form->input('rePass',array('type'=>'text','style'=> 'width: 350px; height: 46px; position: absolute; left: 10px; top: 340px'));

    //へんこうボタン
    echo '<p><input type="submit" name="reChange" value="変更" style=" width: 50px; height: 30px; position: absolute; left: 70px; top: 410px"  /p>'."\n";

    //フォーム解除
    echo $this->Form->end();
}
?>
