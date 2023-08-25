<?php
//4-2以降でも毎回接続は必要。
    //$dsnの式の中にスペースを入れないこと！

    // 【サンプル】
    // ・データベース名：データベース名
    // ・ユーザー名：ユーザー名
    // ・パスワード：パスワード
    // の学生の場合：

    // DB接続設定
    $dsn = 'mysql:dbname=データベース;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
   //テーブル設定
    $sql = "CREATE TABLE IF NOT EXISTS text_board"
    ." ("
    . "id INT AUTO_INCREMENT UNIQUE PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    ."pass INT(3)"
    .");";
    $stmt = $pdo->query($sql);
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
      $sql ='SHOW CREATE TABLE text_board';
    $result = $pdo -> query($sql);
    foreach ($result as $row){
        echo $row[1];
    }
    echo "<hr>";
    
    ?>