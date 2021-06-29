<?php
namespace App\Controller\Component;


use Cake\Controller\Component;
use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
 
class DataComponent extends Component
{
    
    
    //DMの処理
    public function exDM($minute, $id){

        //データベース接続
        $twitterinfosTable = TableRegistry::getTableLocator()->get('twitterinfos');
        //idが$_SESSION['id']のエンティティを持ってくる
        $twitterinfo = $twitterinfosTable->get($id);
                
        $api_key = $twitterinfo->api_key;    // APIキー
        $api_secret = $twitterinfo->api_seckey;    // APIシークレット
        $access_token = $twitterinfo->access_token;  // アクセストークン
        $access_token_secret = $twitterinfo->access_sectoken;    // アクセストークンシークレット
        $request_url = 'https://api.twitter.com/1.1/direct_messages/events/list.json';      // エンドポイント
        $request_method = 'GET' ;
        $para_page = null;//次のページ（20件先）のデータを取ってくるためのパラメータを格納
        $num_select = [0, 0, 0, 0, 0, 0, 0, 0, 0];//選択された数字の票数を格納(1~9)
        $num_chinese = ["一", "二", "三", "四", "五", "六", "七", "八", "九"];//半角数字と漢字を対応させた配列
        $num_full = ["１", "２", "３", "４", "５", "６", "７", "８", "９"];//半角数字と全角数字を対応させた配列
        
        while($para_page != "1"){//まだページが残っている場合は繰返す
            // パラメータA (オプション)
            $params_a = array(
                "count" => "20",
                "cursor" => $para_page,
            ) ;
            // キーを作成する (URLエンコードする)
            $signature_key = rawurlencode( $api_secret ) . '&' . rawurlencode( $access_token_secret ) ;
            // パラメータB (署名の材料用) 
            $params_b = array(
                'oauth_token' => $access_token ,
                'oauth_consumer_key' => $api_key ,
                'oauth_signature_method' => 'HMAC-SHA1' ,
                'oauth_timestamp' => time() ,
                'oauth_nonce' => microtime() ,
                'oauth_version' => '1.0' ,
            ) ;
            // パラメータAとパラメータBを合成してパラメータCを作る
            $params_c = array_merge( $params_a , $params_b );
            // 連想配列をアルファベット順に並び替える
            ksort( $params_c ) ;
            // パラメータの連想配列を[キー=値&キー=値...]の文字列に変換する
            $request_params = http_build_query( $params_c , '' , '&' ) ;
            // 一部の文字列をフォロー
            $request_params = str_replace( array( '+' , '%7E' ) , array( '%20' , '~' ) , $request_params ) ;
            // 変換した文字列をURLエンコードする
            $request_params = rawurlencode( $request_params ) ;
            // リクエストメソッドをURLエンコードする
            // ここでは、URL末尾の[?]以下は付けないこと
            $encoded_request_method = rawurlencode( $request_method ) ;
            $request_url = 'https://api.twitter.com/1.1/direct_messages/events/list.json';
            // リクエストURLをURLエンコードする
            $encoded_request_url = rawurlencode( $request_url ) ;
            // リクエストメソッド、リクエストURL、パラメータを[&]で繋ぐ
            $signature_data = $encoded_request_method . '&' . $encoded_request_url . '&' . $request_params ;
            // キー[$signature_key]とデータ[$signature_data]を利用して、HMAC-SHA1方式のハッシュ値に変換する
            $hash = hash_hmac( 'sha1' , $signature_data , $signature_key , TRUE ) ;
            // base64エンコードして、署名[$signature]が完成する
            $signature = base64_encode( $hash ) ;
            // パラメータの連想配列、[$params]に、作成した署名を加える
            $params_c['oauth_signature'] = $signature ;
            // パラメータの連想配列を[キー=値,キー=値,...]の文字列に変換する
            $header_params = http_build_query( $params_c , '' , ',' ) ;
            // リクエスト用のコンテキスト
            $context = array(
                'http' => array(
                    'method' => $request_method , // リクエストメソッド
                    'header' => array(            // ヘッダー
                        'Authorization: OAuth ' . $header_params ,
                    ) ,
                ) ,
            ) ;
            // パラメータがある場合、URLの末尾に追加
            if( $params_a ) {
                $request_url .= '?' . http_build_query( $params_a ) ;
            }
            // cURLを使ってリクエスト                                                                                                                                                                      
            $curl = curl_init() ;
            curl_setopt( $curl, CURLOPT_URL , $request_url ) ;
            curl_setopt( $curl, CURLOPT_HEADER, 1 ) ;
            curl_setopt( $curl, CURLOPT_CUSTOMREQUEST , $context['http']['method'] ) ;  // メソッド
            curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER , false ) ;  // 証明書の検証を行わない
            curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true ) ;   // curl_execの結果を文字列で返す
            curl_setopt( $curl, CURLOPT_HTTPHEADER , $context['http']['header'] ) ; // ヘッダー
            curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;    // タイムアウトの秒数
            
            $res1 = curl_exec( $curl ) ;
            $res2 = curl_getinfo( $curl ) ;
            curl_close( $curl ) ;
            
            // 取得したデータ
            $json = substr( $res1, $res2['header_size'] ) ;     // 取得したデータ(JSONなど)
            $header = substr( $res1, 0, $res2['header_size'] ) ;    // レスポンスヘッダー (検証に利用したい場合にどうぞ)
            
            // JSONをオブジェクトに変換
            $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
            $obj = json_decode( $json ) ;
            $date_before = date("Y-m-d H:i:s",strtotime("-".$minute." minute"));//指定された分数分前の時刻
            
            $date_beforeText  = new Time($date_before);

            $para_page = $obj->next_cursor;//next_cursorの値をpara_pageに代入
            
            if($para_page == null){//最後のページだった場合
                $para_page = "1";//ループを終了させる
            }
            //print_r($obj->events);
            foreach($obj->events as $data){
                $text=$data->message_create->message_data->text;
                
                for($k=0; $k<mb_strlen($text);$k++){
                    $text_cmp[$k] = mb_substr($text,$k,1);
                }
                $date = date('Y-m-d H:i:s',$data->created_timestamp/1000);
                $date_text = new Time($date);
                
                if($date_beforeText < $date_text){//指定された分数の期間内に送信された内容であった場合
                    
                    for ($i=0; $i < $k ; $i++) {
                        if(is_numeric($text_cmp[$i]) && $text_cmp[$i] != 0){//半角数値であった場合
                            $num_select[$text_cmp[$i]-1] = $num_select[$text_cmp[$i]-1] + 1;//入力された数値の票数を1増やす
                            break;
                        }else{//半角数字でなかった場合
                            for ($j=0; $j < 9 ; $j++) {//漢数字と全角数字の判定
                                if(strcmp($text_cmp[$i], $num_chinese[$j]) == 0){
                                    $num_select[$j] = $num_select[$j] + 1;//入力された数値の票数を1増やす
                                    $i = mb_strlen($text);//外側のループを終了させる
                                    break;
                                }else if(strcmp($num_full[$j],$text_cmp[$i]) == 0){//漢数字または全角数字であった場合
                                    $num_select[$j] = $num_select[$j] + 1;//入力された数値の票数を1増やす
                                    $i = mb_strlen($text);//外側のループを終了させる
                                    break;
                                }
                            }
                        }
                    }
                }else{////指定された分数の期間外に送信された内容であった場合
                    $para_page = "1";//外側のwhileのループから抜ける
                    break;//ループを終了させる
                }
            }
            
            /*
            if (empty($obj->next_cursor)) {
                //echo "aaaaaaaaaaa\n";
                break;
            }else{
               $para_page = $obj->next_cursor;//next_cursorの値をpara_pageに代入
            }
            if($para_page == null){//最後のページだった場合
                $para_page = "1";//ループを終了させる
            }
            */
        }
        //集計結果が格納された配列を返す
        return $num_select;
    }

    
    //itodai-sasanatsu-nakadai
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function exReply($minutes,$id){
        //$post_data=$this->request->getData();
        //echo $id;
        //$session=$this->getRequest()->getSession();
        //session_start();
        //var_dump( $session->read('id'));
        $TwitterinfosTable=TableRegistry::getTableLocator()->get('twitterinfos');
        //$twitter = $TwitterinfosTable->get($session->read('id'));
        //      var_dump($id);
        $twitter = $TwitterinfosTable->get($id);
        
        $api_key=$twitter['api_key'];
        $api_secret=$twitter['api_seckey'];
        $access_token=$twitter['access_token'];
        $access_token_secret=$twitter['access_sectoken'];
        $screen_name=$twitter['twitter_id'];

        $request_url = 'https://api.twitter.com/1.1/statuses/mentions_timeline.json' ; // エンドポイント
        
        $request_method = 'GET' ;
        $respon;
        $pre=[0,0,0,0,0,0,0,0,0];

        $screen_count=strlen($screen_name)+1;

        $params_a = array(
            "count" => "100",
            "count" => "100",
            "trim_user" => "true",
        ) ;
        // キーを作成する (URLエンコードする)
        
        $signature_key = rawurlencode( $api_secret ) . '&' . rawurlencode( $access_token_secret ) ;
        
        // パラメータB (署名の材料用)
        
        $params_b = array(
            'oauth_token' => $access_token ,
            'oauth_consumer_key' => $api_key ,
            'oauth_signature_method' => 'HMAC-SHA1' ,
            'oauth_timestamp' => time() ,
            'oauth_nonce' => microtime() ,
            'oauth_version' => '1.0' ,
        ) ;
        
        // パラメータAとパラメータBを合成してパラメータCを作る
        
        $params_c = array_merge( $params_a , $params_b ) ;
        
        // 連想配列をアルファベット順に並び替える
        
        ksort( $params_c ) ;
        
        // パラメータの連想配列を[キー=値&キー=値...]の文字列に変換する
        
        $request_params = http_build_query( $params_c , '' , '&' ) ;
        
        // 一部の文字列をフォロー
        
        $request_params = str_replace( array( '+' , '%7E' ) , array( '%20' , '~' ) , $request_params ) ;
        
        // 変換した文字列をURLエンコードする
        $request_params = rawurlencode( $request_params ) ;
        
        // リクエストメソッドをURLエンコードする
        
        // ここでは、URL末尾の[?]以下は付けないこと
        
        $encoded_request_method = rawurlencode( $request_method ) ;
        
        // リクエストURLをURLエンコードする
        
        $encoded_request_url = rawurlencode( $request_url ) ;
        // リクエストメソッド、リクエストURL、パラメータを[&]で繋ぐ
        
        $signature_data = $encoded_request_method . '&' . $encoded_request_url . '&' . $request_params ;
        
        // キー[$signature_key]とデータ[$signature_data]を利用して、HMAC-SHA1方式のハッシュ値に変換する
        
        $hash = hash_hmac( 'sha1' , $signature_data , $signature_key , TRUE ) ;
        
        // base64エンコードして、署名[$signature]が完成する
        
        $signature = base64_encode( $hash ) ;
        
        // パラメータの連想配列、[$params]に、作成した署名を加える
        
        $params_c['oauth_signature'] = $signature ;
        
        // パラメータの連想配列を[キー=値,キー=値,...]の文字列に変換する
        
        $header_params = http_build_query( $params_c , '' , ',' ) ;
        
        // リクエスト用のコンテキスト
        
        $context = array(
            'http' => array(
                'method' => $request_method , // リクエストメソッド
                
                'header' => array(            // ヘッダー
                    
                    'Authorization: OAuth ' . $header_params ,
                ) ,
            ) ,
        ) ;
        
        // パラメータがある場合、URLの末尾に追加
        
        if( $params_a ) {
            $request_url .= '?' . http_build_query( $params_a ) ;
        }
        
        // cURLを使ってリクエスト
        
        $curl = curl_init() ;
        curl_setopt( $curl, CURLOPT_URL , $request_url ) ;
        curl_setopt( $curl, CURLOPT_HEADER, 1 ) ;
        curl_setopt( $curl, CURLOPT_CUSTOMREQUEST , $context['http']['method'] ) ;  // メソッド
        
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER , false ) ;  // 証明書の検証を行わない
        
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER , true ) ;   // curl_execの結果を文字列で返す
        
        curl_setopt( $curl, CURLOPT_HTTPHEADER , $context['http']['header'] ) ; // ヘッダー
        
        curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;    // タイムアウトの秒数
        
        $res1 = curl_exec( $curl ) ;
        $res2 = curl_getinfo( $curl ) ;
        curl_close( $curl ) ;
        
        // 取得したデータ                                                                                                                                     
        
        $json = substr( $res1, $res2['header_size'] ) ;
        
        // JSONをオブジェクトに変換
        
        $obj = json_decode( $json ) ;
        //
                
        //print_r($obj);
        
        $first_names = array_column($obj,'text');
        //              var_dump($first_names);
        
        $second_names = array_column($obj, 'created_at');
        for($count=0;count($second_names)>$count;$count++){
            $create_date[$count] = new \DateTime($second_names[$count]);
            $create_date[$count]->setTimezone(new \DateTimeZone('Asia/Tokyo'));
            
        }
        
        //タイムゾーンを設定しなおす
        
        $datebefore=date('Y-m-d H:i:s',strtotime("-".$minutes."minute"));
        $dateText=new \DateTime($datebefore);
                
        //$time = Time::now();
        //$time=$time->modify('-5 minutes');
        //$dateText=($time->i18nFormat('yyyy-MM-dd HH:mm:ss'));
        $dateText->setTimezone(new \DateTimeZone('Asia/Tokyo'));
        
        //echo $first_names[0];
        
        for($count=0;$count<count($first_names);$count++){
            
            if($dateText<$create_date[$count]){
                        
                $respon[$count] = substr( $first_names[$count], $screen_count , strlen($first_names[$count])-$screen_count);
            }
        }
        if(isset($respon)){
            //                   var_dump($respon);
            
            
            $num=[1,2,3,4,5,6,7,8,9];
            $numkanji=["一","二","三","四","五","六","七","八","九"];
            $bignum=["１","２","３","４","５","６","７","８","９"];
            $numarray=array();
            
            for($mojicon=0;count($respon)>$mojicon;$mojicon++){
                for($numcount=0;count($num)>$numcount;$numcount++){
                    
                    if(strcmp($bignum[$numcount],$respon[$mojicon])==0){
                        array_push($numarray,$num[$numcount]);
                        break;
                    }
                    elseif(strcmp($numkanji[$numcount],$respon[$mojicon])==0){
                        array_push($numarray,$num[$numcount]);
                        break;
                        
                    }elseif($num[$numcount]==$respon[$mojicon]){
                        
                        array_push($numarray,$num[$numcount]);
                    }
                }
            }
                        
            for($count=0;count($numarray)>$count;$count++){//numarrayの中身を見る
                
                for($con=1;count($num)+2>$con;$con++){
                    if($numarray[$count]==$con){
                        $pre[($con-1)]++;
                    }
                }
            }
            
            return $pre;
            
        }else{
            // print_r("bbb\n");
            
            return null;
            
        }
        
    }
      
    function exTag($time,$ID){

    // 設定
    $bearer_token = 'AAAAAAAAAAAAAAAAAAAAAB%2F7KAEAAAAAT6tKKZ8FtnOR4uuJhsbbSTt9i3E%3Dn53q2kzonlIV55LH7oE4mLci0oT1qj6kmQWJuiqJ5CVLyquCqg' ;  // ベアラートークン
    $request_url = 'https://api.twitter.com/1.1/search/tweets.json' ;       // エンドポイント


    $TwitterinfosTable =TableRegistry::getTableLocator()->get('twitterinfos');
    $tag = $TwitterinfosTable -> get($ID)->hashtag;
        
    //$tag_info = $this -> get_info($ID);
    $vote = [0,0,0,0,0,0,0,0,0];
    date_default_timezone_set("Asia/Tokyo");

    //print_r($tag_info);

    $time = (int)$time;
    //var_dump( strtotime(-$time."minutes"));
    $limit = strtotime(-$time."minutes");
    $Slimit = date("Y-m-d_H:i:s",$limit);
    // var_dump(date("Y-m-d_H:i:s",$limit));


    // パラメータ (オプション)
    $params = array(
        "q" =>$tag ,
        "count" => "100",
        "max_id" => NULL,
        "since" => $Slimit,
    ) ;

    for($i = 0 ; ; $i++){
        // パラメータがある場合
        if( $params ) {
            $request_url = 'https://api.twitter.com/1.1/search/tweets.json';
            $request_url .= '?' . http_build_query( $params );
        }
        //print($request_url."\n");
        //print($params["q"]."\n");
        
        // リクエスト用のコンテキスト
        $context = array(
            'http' => array(
                'method' => 'GET' , // リクエストメソッド
                'header' => array(            // ヘッダー
                    'Authorization: Bearer ' . $bearer_token ,
                ) ,
            ) ,
        ) ;
        
        // cURLを使ってリクエスト
        $curl = curl_init() ;
        curl_setopt( $curl , CURLOPT_URL , $request_url ) ;
        curl_setopt( $curl , CURLOPT_HEADER, 1 ) ;
        curl_setopt( $curl , CURLOPT_CUSTOMREQUEST , $context['http']['method'] );// メソッド
        curl_setopt( $curl , CURLOPT_SSL_VERIFYPEER , false ) ;                             // 証明書の検証を行わない
        curl_setopt( $curl , CURLOPT_RETURNTRANSFER , true ) ;                              // curl_execの結果を文字列で返す
        curl_setopt( $curl , CURLOPT_HTTPHEADER , $context['http']['header'] ) ;            // ヘッダー
        curl_setopt( $curl , CURLOPT_TIMEOUT , 5 ) ;                                        // タイムアウトの秒数
        $res1 = curl_exec( $curl ) ;
        $res2 = curl_getinfo( $curl ) ;
        curl_close( $curl ) ;
        
        // 取得したデータ
        $json = substr( $res1, $res2['header_size'] ) ;             // 取得したデータ(JSONなど)
        $header = substr( $res1, 0, $res2['header_size'] ) ;        // レスポンスヘッダー (検証に利用したい場合にどうぞ)
        
        // JSONをオブジェクトに変換 (処理をする場合)
        $obj = json_decode( $json, true );
        //var_dump( $obj);
        
        for( $i = 0; $i < count($obj["statuses"]); $i++){
            
            // var_dump($obj["statuses"][$i]["text"]."\n");
            //print($obj["statuses"][$i]["created_at"]."\n");

            
            //ツイート作成時間を調べる
            $timestamp = strtotime($obj["statuses"][$i]["created_at"]);
            //var_dump($timestamp);
            $datetime = date('Y-m-d H:i:s', $timestamp);
            //var_dump($datetime);
                       
            //指定時間以内か比較する
            if($limit < $timestamp){
              
                //文だけにする
                $trimmed = trim($obj["statuses"][$i]["text"],$tag);
                $trimmed = trim($trimmed," ");
                $trimmed = trim($trimmed,"\r\n");
                
                //何に投票されてるか判別する
                $num = $this -> check_num($trimmed);
                //var_dump($trimmed);
                
                if(  0 <  $num  ){
                    $vote[$num -1] += 1;
                }
            }
        }
        
        // 先頭の「?」を除去
        // $next_results = preg_replace('/^\?/','', $obj['search_metadata']['next_results']);
        // next_results が無ければ処理を終了
        //$next_results = null;
        //$next_results = $obj['search_metadata']['next_results'];
        if (empty($obj['search_metadata']['next_results'])) {
            //echo "aaaaaaaaaaa\n";
            break;
        }else{
            $next_results = preg_replace('/^\?/','', $obj['search_metadata']['next_results']);
        }
        
        // パラメータに変換
        parse_str($next_results, $params);
        
    }
    //var_dump($vote);
    return $vote;
    }

    
    //文の中の数字を見つける関数
    function check_num($str){
        $trim_num = 1; //取り除く文字数
        $num = 0;
        
        for($i= 0; $i < mb_strlen($str); $i++){
            
            //番号判定
            $num =  $this ->reNum(mb_substr($str,$i,$trim_num));
            
            if( $num !=0)
                break;
        }
        
        return $num;
    }
    //番号を判別する関数
    function reNum($n){
        
        //var_dump($n);
        
        //選択番号
        $full_num = ["１","２","３","４","５","６","７","８","９"];
        $jp_num = ["一","二","三","四"."五","六","七","八","九"];        
        for($i = 0; $i < count($jp_num); $i++){
            if($n == $i+1){ //半角だったら
                $number = $i+1;
                //print($i+1."\n");
                break;
            }else if(strcmp($n,$full_num[$i]) == 0){ //全角だったら
                $number = $i+1;
                //print($full_num[$i]."\n");
                break;
            }else if(strcmp($n,$jp_num[$i]) == 0){ //漢数字だったら
                $number = $i+1;
                //print($jp_num[$i]."\n");
                break;
            }else{
                $number = 0;
            }
        }
        return $number;
        
    }


}
?>
