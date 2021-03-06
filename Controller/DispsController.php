<?php
//おまじない　必ずつける
namespace App\Controller;
use App\Controller\AppController;


//class名はファイル名と合わせる
class DispsController extends AppController
{
    
    
    function index(){
        
        $session = $this->getRequest()->getSession();
        $id = $session->read('id');
        $this -> set('min',null);
        if(null == ($session->read('id'))){
            $loginError = 1;
            $this->redirect(['controller' => 'Login','action' =>'index',$loginError]);
        }else{
            
            $userName = $this ->users ->get($id)->username;
            //var_dump($id);
            $this -> set('name',$userName);
            //var_dump($userName);
            if($this->getRequest()->getQuery('minutes') != null){
                $time = $this->getRequest()->getQuery('minutes');
                $this -> set('min',$time);
                //var_dump($time);
                $this -> order($id,$time);
            }else{
            }
        }
    }

    function order($id,$time){
        $TwitterinfosTable = $this ->twitterinfos;
        $tag = $TwitterinfosTable -> get($id)->hashtag;
        $this->loadComponent('Data');

        $voteTag = $this->Data->exTag($time,$id);
        //var_dump($voteTag);

        if($TwitterinfosTable -> get($id)->api_key!=null){
            $voteReply = $this ->Data-> exReply($time,$id);
            //print_r($voteReply);
            
        }

        if($TwitterinfosTable -> get($id)->api_key!=null){
            //$voteDM = $this ->Data-> exDM($time,$id);
            //print_r($voteDM);
        }
        
        for($i = 0; $i < count($voteTag); $i++){

            //$total[] = $voteTag[$i] + $voteReply[$i]  + $voteDM[$i];
            $total[] = $voteTag[$i];
             /*  
             if($total[$i] == 0){
                 unset($total[$i]);
             }
             */
             
        }
        
        //var_dump($total);
        $img_path = $this ->create_bar($total);

       
        
    }
    /*
    function create_pie($vote,$name){
        
        $values = $vote;
        //var_dump($values);
        // print("\n");
        
        $width   = 450;
        $height  = 300;
        
        
        //円の中心座標
        $cy = round( $height / 2 );
        $cx = round( $cy );

        $image = imagecreatetruecolor($width, $height);

        //背景
        $bg      = imagecolorallocate( $image, 255, 255, 255 );
        imagefill($image, 0, 0, $bg);
        
        //グラフに使う色
        $colorset = $this -> get_color();
        //黒色の定義
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);
      
        list($red, $green, $blue) = $this -> parse_color($colorset[0]);
        
        //rsort($values);
        $scale = 360 / array_sum($values);
        $count = count($values);
        
        $start = -90;
        $end = $start;

        foreach($values as $key => $value){
            if($value == 0){
                $res = next($colorset);
                if($res === false) reset($colorset);
                continue;
            }
            list($red, $green, $blue) = $this ->parse_color(current($colorset));
            $start = $end;
            $end = ($key === $count - 1) ? 270 : $end = $value * $scale + $start;
            $color = imagecolorallocate($image, $red, $green, $blue);
            imagefilledarc($image, $cx, $cy, $height, $height, $start, $end, $color, IMG_ARC_PIE);
            $res = next($colorset);
            if($res === false) reset($colorset);
        }
        
        for($i = 0 ; $i < count($vote); $i++){
            
            list($red, $green, $blue) = $this -> parse_color( $colorset[$i] );
            $color = imagecolorallocate($image, $red, $green, $blue);
            
            //凡例(塗りつぶし長方形)：右から 画像,左上X,左上Y,右下X,,右下Y,文字列,色
            imagefilledrectangle( $image, 425 , 15+($i*20)  , 435  , 25+($i*20) , $color );
            //凡例(文字)：右から 画像,フォント,左上X,左上Y,文字列,色
            imagestring($image, 5 , 325 , (11+$i*20) ,"select : " .($i+1), $black);
        }
       imagecolortransparent($image, $white); 
        
        // 画像出力
        $file_name = $name."_pie_chart_".date( "Y_m_d_H:i:s" ).".png";
        // $file_name = './Imgdir/'.$file_name.'.png';
        $path = WWW_ROOT."img/Imgdir/".$file_name;
        
       
        if(!imagepng($image,$path))
            echo 1;
        
        $this->set('file_name', $file_name);
        imagedestroy($image);
        
    }
    */
    function create_bar($vote){
        
        //値
        $values = $vote;

        //パーセンテージを計算
        $percentage = $this ->culc_percentage($vote);

        //最大の要素をmax_pointに格納する
        $max_point = 0;
        $max_element = 0;
        $j = 0;
        $max_num = [];

        //最大値を調べる
        for($i = 0;$i < count($percentage);$i++){
            if($percentage[$i] >= $max_point){
                $max_point = $percentage[$i];
                $max_element = $i;
            }
        }
        
        $max     = 10; //上限
        if($max < $vote[$max_element])
            $max     = $vote[$max_element]; //上限
        
        $step    = $max/5;  //目盛の刻み

        //最大の要素をmax_pointに格納する
        for($i = 0;$i < count($percentage);$i++){
            if($max_point == $percentage[$i]){
                $max_num[$j] = $i;
                $j++;
            }
        }
        
        $width   = 300;
        $height  = 200;
        $bar_width = 20;

        $font_size = 10;
        
        $margin_top      = 50;
        $margin_right    = 30;
        $margin_bottom   = 50;
        $margin_left   = 50;
              
        $image = imagecreate($width + $margin_left + $margin_right, $height + $margin_top + $margin_bottom);
 
        $org_x = $margin_left;
        $org_y = $height + $margin_top;
 
        //色
        $bg_color   = imagecolorallocate( $image, 255, 255, 255 );
        $line_color = imagecolorallocate($image, 100,100, 80);
        $bar_color  = imagecolorallocate($image, 100, 180, 255);
        $grid_color = imagecolorallocate($image, 50, 50, 50);
        $font_color = imagecolorallocate($image, 255, 160, 200);
        $color_best  = imagecolorallocate($image, 230, 0, 0);     
        $black = imagecolorallocate($image, 0, 0, 0);
        $grid_spacing = $height / $max * $step;
        
        imagefill($image, 0, 0, $bg_color);

        $count = count($vote);
        $bar_spacing = floor( ($width - $bar_width) / $count);

        //グラフの基線
        imageline($image, $org_x, $org_y, $org_x, $margin_top, $line_color);
        imageline($image, $org_x, $org_y, $org_x + $width, $org_y, $line_color);


        imagestring($image, 5,20,40,  $max ,$black);
        imagestring($image, 5,20,80,  (int)($max/5 * 4), $black);
        imagestring($image, 5,20,120, (int)($max/5 * 3), $black);
        imagestring($image, 5,20,160, (int)($max/5 * 2), $black);
        imagestring($image, 5,20,200, (int)($max/5 * 1), $black);
        imagestring($image, 5,20,240, $max/5 * 0, $black);
        
        //横線を描画
        for($i=0;$i<floor($max / $step);$i++){
            if($i !== 0) imageline($image, $org_x, $org_y - $grid_spacing * $i, $org_x + $width, $org_y - $grid_spacing * $i, $grid_color);
        }

        
        for($i=0;$i<$count;$i++){
            $bar_x = $org_x + $bar_spacing * ($i + 1) - ($bar_spacing / 2);
            $bar_y = $org_y - $height * $vote[$i] / $max;

            //最大の要素だけ色を変える
            for($j = 0;$j < count($max_num);$j++){
                if($i == $max_num[$j]){
                    //if($vote[$i] < $max)
                        //imagestring($image, 5,$bar_x + 8,80, $vote[$i] ,$black);
                    if($vote[$i]!=0){
                        imagestring($image, 5,$bar_x + 6,$bar_y - 15, $vote[$i] ,$black);
                        imagefilledrectangle($image, $bar_x, $org_y, $bar_x + $bar_width, $bar_y, $color_best);
                        imagechar($image, 5, $bar_x + 8, 260, $i + 1, $color_best);
                        $j++;
                    }else{
                    imagefilledrectangle($image, $bar_x, $org_y, $bar_x + $bar_width, $bar_y, $bar_color);
                    imagechar($image, 5, $bar_x + 8, 260, $i + 1, $black);
                    $j++;
                    }
                }else{
                    if($vote[$i]!=0)
                    imagestring($image, 5,$bar_x + 8,$bar_y - 15, $vote[$i] ,$black);
                    imagefilledrectangle($image, $bar_x, $org_y, $bar_x + $bar_width, $bar_y, $bar_color);
                    imagechar($image, 5, $bar_x + 8, 260, $i + 1, $black);
                    
                }

            }
        }
        
        $count = count($values);
        $bar_spacing = floor( ($width - $bar_width) / $count);


        $text = "Result of Questionnaire";
        imagestring($image, 5 , 100 ,10 ,$text, $black);

        
        /*日本語フォントを読み込んで表示する。
        $text = "アンケートの結果";
        $font = WWW_ROOT."font/ipaexg.ttf";
        imagettftext($image, 15, 0, 100, 20, $black, $font, $text);
        */
        
        $session = $this->getRequest()->getSession();
        $id = $session->read('id');
        $name = $this ->users ->get($id)->username;
        // 画像出力
        $file_name = $name."_bar_chart_".date( "Y_m_d_H:i:s" ).".png";
        $path = WWW_ROOT."img/Imgdir/".$file_name;

        imagecolortransparent($image, $bg_color);
        if(!imagepng($image,$path))
            echo 1;
        
        $this->set('file_name', $file_name);
        imagedestroy($image);
    }

    
    function culc_percentage($vote){
        $percentage = [];

        //総回答数を格納
        $ans_num = 0;

        $max = 0;
        $j = 0;

        for($i = 0;$i < count($vote);$i++){
            $ans_num = $ans_num + $vote[$i];
        }

        if($ans_num != 0){
            for($i = 0;$i < count($vote);$i++){
                $percentage[$i] = round($vote[$i] / ($ans_num) * 100,2);
            }
        }else{
            $percentage = [0];
        }
        return $percentage;
    }
    /*
    function parse_color($rgb){
        $res = str_split($rgb, 2);
        $red     = intval($res[0], 16);
        $green   = intval($res[1], 16);
        $blue    = intval($res[2], 16);
        return array( $red, $green, $blue );
    }

    function get_color(){
        
        $color_list = array(
            'ff3b3b', 'bc3bff', '44aeff', 'aeff3b', 'ffa53b','006400','4169e1','ffa500','3cb371'
        );
        
        return $color_list;
    }
    */
}
?>
