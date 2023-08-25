<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission5-1</title>
    </head>
    <body>
        <h1>簡易掲示板(ミッション5-1)</h1>
          <h2>実行結果</h2>
     <?php
     //各変数の初期値設定
     $name="";
     $str="";
     $edit_num="";
     $edit_name="";
     $edit_comment="";
     // DB接続設定
     $dsn = 'データベース;host=localhost';
     $user = 'ユーザー名';
     $password = 'パスワード';
     $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
     
     //送信フォームが使用されたときの処理
     if(!empty($_POST["name"])&&!empty($_POST["str"])){
        if(!empty($_POST["pass_resist"])){
           $pass = $_POST["pass_resist"];
           echo "パスワードを登録しました<br>";
         }else{
             echo "パスワードが登録されていません<br>";
         }
         if(empty($_POST["edit_Con"])){//新規投稿
          $name = $_POST["name"];
          $comment = $_POST["str"]; 
          $date = date("Y/m/d/ H:i:s");
          $sql = "INSERT INTO text_board (name, comment, pass ,date) VALUES (:name, :comment, :pass, :date)";
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':name', $name, PDO::PARAM_STR);
          $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
          $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
          $stmt->bindParam(':date', $date, PDO::PARAM_STR);
          $stmt->execute();
          echo "投稿完了：新規投稿を受け付けました。<br>";
         }else{//編集
          $new_name = $_POST["name"];
          $new_comment = $_POST["str"];
          $id = $_POST["edit_Con"];
          $pass = $_POST["edit_pass"];
          $date = date("Y/m/d/ H:i:s");
          $sql = 'UPDATE text_board SET name=:name,comment=:comment,pass=:pass,date=:date WHERE id=:id ' ;
          $stmt = $pdo->prepare($sql);
          $stmt->bindParam(':name', $new_name, PDO::PARAM_STR);
          $stmt->bindParam(':comment', $new_comment, PDO::PARAM_STR);
          $stmt->bindParam(':id', $id, PDO::PARAM_INT);
          $stmt->bindParam(':pass', $pass, PDO::PARAM_INT);
          $stmt->bindParam(':date',$date, PDO::PARAM_STR);
          $stmt->execute();
          echo "編集完了:投稿番号".$id."を編集しました。<br>";
             }
     }
     
     //削除フォームが使用されたときの処理
     if(isset($_POST["delete"])==true&&!empty($_POST["delete_num"])&&!empty($_POST["delete_pass"])){
      $id=$_POST["delete_num"];
      $pass = $_POST["delete_pass"];
      $sql = 'DELETE from text_board where id=:id AND pass=:pass';
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
      $stmt->execute();
      echo "削除完了:投稿番号".$id ."を削除しました<br>";
     }
     
     //編集フォームが使用されたときの処理
     if(isset($_POST["edit"])==true&&!empty($_POST["edit_num"])&&!empty($_POST["edit_pass"])){
      $edit_num = $_POST["edit_num"];
      $edit_pass = $_POST["edit_pass"];
      $sql = 'SELECT*from text_board WHERE id=:id AND pass=:pass';
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':id',$edit_num,PDO::PARAM_INT);
      $stmt->bindParam(':pass',$edit_pass,PDO::PARAM_INT);
      $stmt->execute();                             
      $results = $stmt->fetchAll(); 
         foreach ($results as $row){
          $edit_name = $row['name'];
          $edit_comment = $row['comment'];
         }
         echo "編集可能：送信フォームから編集してください<br>";
     }
     
    
     ?>
        
        <h2>送信フォーム</h2>
         <form action=" " method="post">
           <input type ="string" name ="name" value = "<?php echo $edit_name; ?>"  placeholder ="ここに名前を入力">
           <input type ="text" name="str" value = "<?php echo $edit_comment; ?>" placeholder="ここにコメントを入力">
            <input type = "number" name ="pass_resist" placeholder ="パスワードを登録(任意)">
           <input type = "submit" name="submit">
           <p>※以下のフォームの利用にはパスワードの登録が必要です。</p>
　　　  <h3>削除フォーム</h3>
    　      <input type ="number"name ="delete_num" placeholder = "削除する番号を入力">
             <input type ="number" name = "delete_pass" placeholder="パスワードを入力(必須)">
              <input type = "submit" name="delete" value = "削除">
    　  <h3>編集フォーム</h3>
    　      <input type = "number" name = "edit_num" placeholder = "編集する番号を入力" >
    　      <input type = "number" name = "edit_pass" placeholder ="パスワードを入力（必須）">
    　      <input type = "submit"name = "edit" value = "編集">
    　　<!--編集確認フォーム-->
    　　    <input  type ="hidden" name = "edit_Con" value ="<?php echo$edit_num?>" >
    　　 </form>
    　　 <h2>表示欄</h2>
    <?php
     //表示の処理 
     $sql = 'SELECT * FROM text_board';
     $stmt = $pdo->query($sql);
     $results = $stmt->fetchAll();
         foreach ($results as $row){
          echo $row['id']." ".$row['name']." ".$row['date']."<br>";
          echo $row['comment'].'<br>';
          echo "<hr>";
    }
     ?>
       </html>
      