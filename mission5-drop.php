<?php
//4-2以降でも毎回接続は必要。
    //$dsnの式の中にスペースを入れないこと！

    // 【サンプル】
    // ・データベース名：データベース
    // ・ユーザー名：ユーザー名
    // ・パスワード：パスワード
    // の学生の場合：

    // DB接続設定
    $dsn = 'mysql:dbname=データベース;host=localhost';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    //4-1で書いた「// DB接続設定」のコードの下に続けて記載する。
    // 【！この SQLは text_board テーブルを削除します！】
        $sql = 'DROP TABLE text_board';
        $stmt = $pdo->query($sql);
        ?>