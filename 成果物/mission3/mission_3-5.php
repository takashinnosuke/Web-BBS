<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_3-5</title>
</head>
<body>
    
    
    <?php
        if(isset($_POST["str"])){
            $str = $_POST["str"];
        }
        if(isset($_POST["name"])){
            $name = $_POST["name"];
        }
        if(isset($_POST["delete_str"])){
            $delete_str = $_POST["delete_str"];
        }
        if(isset($_POST["edit_str"])){
            $edit_str = $_POST["edit_str"];
        }
        if(isset($_POST["password1"])){
            $password1 = $_POST["password1"];
        }
        
        $time = date("Y/m/d H:i:s");
        $filename = "mission_3-5.txt";
        $fp = fopen($filename, "a");
        
        //投稿番号の設定
        if (file_exists($filename)){
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            $dev_str = explode("<>", end($lines));
            $num = $dev_str[0] + 1;
        }
        else{
            $num = 1;
        }
        
        
        //編集対象番号が入力されている場合
        if (isset($edit_str)){
            
            if (file_exists($filename)){
                //ファイルを1行ずつ読み込み，配列変数に代入する
                $lines = file($filename, FILE_IGNORE_NEW_LINES);
                    
                //ファイルを読み込んだ配列を，配列の数だけループさせる
                foreach ($lines as $line){
                        
                    //区切り文字「<>」で分割して，それぞれの値を取得
                    $dev_str = explode("<>", $line);
                    //投稿番号を取得して，編集対象番号と比較
                    if ($dev_str[0] == $edit_str){
                        if ($_POST["password3"] == $dev_str[4]){
                            //等しい場合は，その投稿の「名前」と「コメント」を取得
                            $edit_name = $dev_str[1];//名前
                            $edit_str2 =  $dev_str[2];//コメント
                            $edit_num = $dev_str[0];//投稿番号
                            $edit_password = $dev_str[4];//パスワード
                        }
                        else{
                            echo "error :パスワードが違います<br>";
                        }
                    }
                    else{
                    //等しくない場合は，何も書き込まない
                    }
                }
            }
        }
        
        
        //名前，内容が空でない場合
        if($_POST["name"] != "" && $_POST["str"] != "" && empty($delete_str) && empty($edit_str)){

            //新しいテキストボックス内が空かどうか確認する
            if (isset($_POST["edit_num"])){
                //空でない場合
                if (file_exists($filename)){
                    //ファイルを1行ずつ読み込み，配列変数に代入する
                    $lines = file($filename, FILE_IGNORE_NEW_LINES);
                    ftruncate($fp, 0);
                    //ファイルを読み込んだ配列を，配列の数だけループさせる
                    foreach ($lines as $line){
                        
                        //区切り文字「<>」で分割して，それぞれの値を取得
                        $dev_str = explode("<>", $line);
                        //投稿番号を取得して，編集対象番号と比較
                        if ($dev_str[0] == $_POST["edit_num"]){
                            //等しい場合は，ファイルに書き込む内容を送信内容に差し替える
                            
                            $line =  $dev_str[0] . "<>" . $name . "<>" . $str . "<>" . $time . "<>" . $password1 . "<>";
                            fwrite($fp, $line.PHP_EOL);
                        }
                        else{
                            //等しくない場合は，追加書き込みする
                            fwrite($fp, $line.PHP_EOL);
                        }
                    }
                }
            }
            
            //空の場合
            else{
                //書き込む文字列を変数に代入する
                $com = $num . "<>" . $name . "<>" . $str . "<>" . $time . "<>" . $password1 . "<>";
                fwrite($fp, $com.PHP_EOL);
            }
            fclose($fp);
        }
        

        //削除対象番号が入力されている場合
        if (isset($delete_str)){
            
            if (file_exists($filename)){
                
                //ファイルを1行ずつ読み込み，配列変数に代入する
                $lines = file($filename, FILE_IGNORE_NEW_LINES);
                $fp = fopen($filename, "a");
                ftruncate($fp, 0);
                    
                //ファイルを読み込んだ配列を，配列の数だけループさせる
                foreach ($lines as $line){
                        
                    //区切り文字「<>」で分割して，それぞれの値を取得
                    $dev_str = explode("<>", $line);
                    //投稿番号を取得して，削除対象番号と比較
                    if ($dev_str[0] != $delete_str){
                        //等しくない場合は，追加書き込みを行う
                        fwrite($fp, $line.PHP_EOL);
                        }
                        
                    else{
                        //等しい場合は，何も書き込まない
                        //パスワードが正しい場合
                        if ($_POST["password2"] == $dev_str[4]){
                            
                        }
                        //パスワードが異なる場合
                        else{
                            fwrite($fp, $line.PHP_EOL);
                            echo "error :正しいパスワードを入力してください<br>";
                        }
                    }
                }
                    fclose($fp);
            }
        }
    ?>
        
        <form action="" method="post">
        <input type = "text" name = "name" placeholder = "名前"
        value = "<?php if (isset($edit_name)){echo $edit_name;} ?>"><br>
        <input type = "text" name = "str" placeholder = "コメント"
        value = "<?php if (isset($edit_name)){echo $edit_str2;} ?>"><br>
        <input type = "password" name = "password1" placeholder = "パスワード">
        <input type = "hidden" name = "edit_num" placeholder = "指定投稿番号"
        value = "<?php if (isset($edit_num)){echo $edit_num;} ?>">
        <input type = "submit" name = "submit"><br><br>
        <input type = "text" name = "delete_str" placeholder = "削除番号"><br>
        <input type = "password" name = "password2" placeholder = "パスワード">
        <input type = "submit" name = "delete_submit" value = "削除"><br><br>
        <input type = "text" name = "edit_str" placeholder = "編集番号"><br>
        <input type = "password" name = "password3" placeholder = "パスワード">
        <input type = "submit" name = "edit_submit" value = "編集">
    </form>
      
    <?php    
        if (file_exists($filename)){
            //ファイルを1行ずつ読み込み，配列変数に代入する
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
                
            //ファイルを読み込んだ配列を，配列の数だけループさせる
            foreach ($lines as $line){
                    
                //区切り文字「<>」で分割して，それぞれの値を取得
                $dev_str = explode("<>", $line);
                //パスワード要素を削除する
                unset($dev_str[4]);
                //上記で取得した値をechoを用いて表示
                $linestr = implode(" ", $dev_str);
                echo $linestr . "<br>";
            }
        }
    ?>
    
</body>
</html>