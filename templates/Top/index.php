<?php

$this->assign('title', 'トップページ');;
echo "<body>\n";
echo "<p>".'<div style="display:inline-block; padding-right: 50px;  padding-left: 50px; margin-bottom: 10px; border: 1px solid #333333; text-align: center;">'."\n";
echo '<font size="7">トップページ</font>'."\n";
echo "</div></p>";

echo "<p style=".'"position:absolute;top:85px;left:30px;text-align: center;"'."><MARQUEE bgcolor='#e5f1ff' width='240' scrollamount='4'><FONT color= '#000099'>".$name."でログイン中！"."</FONT></MARQUEE>";

echo "<br />";
echo "<p style = ".'"position:absolute;top:150px;left:100px;text-align: center;"'."><font size = '5'><a href="."Config".">登録情報設定ページへ</a>";
echo "</form>\n";
echo "<br />";

echo "<br />";
echo "<p style = ".'"position:absolute;top:210px;left:100px;text-align: center;"'."><font size = '5'><a href="."Disps".">グラフページへ</a>";
echo "<br />";


echo $this->Form->create(null,["type"=>"post","url"=>["controller"=>"Logout","action"=>"index"]]);
echo "<p><center><input type=".'"submit"'."value=".'"ログアウト"'."style = ".'"position:absolute;top:100px;left:315px;"'."/>\n";
echo $this->Form->end();

echo "</body>\n";

echo "</html>\n";

?>
