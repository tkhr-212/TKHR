<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
</head>
<body>

<?php

	$name = (string)filter_input( INPUT_POST, "name" );//post送信された投稿者の名前
    $comment = (string)filter_input( INPUT_POST, "comment");//post送信された投稿コメント
    $delete = (string)filter_input( INPUT_POST, "delete");//postされた削除番号
    $edit  = (string)filter_input( INPUT_POST, "edit");//postされた編集内容
    $ednum = (string)filter_input( INPUT_POST, "number");//post送信された編集番号
    $pass = (int)filter_input( INPUT_POST, "pass" );//post送信された投稿パスワード
	$dpass = (int)filter_input( INPUT_POST, "dpass" );//post送信された投稿パスワード
	$epass = (int)filter_input( INPUT_POST, "epass" );//post送信された投稿パスワード
	$date = date("Y/m/d H:i:s");
	// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
// 	データレコード挿入
	try{
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
        if (empty($pass)==false&&empty($name)==false&&empty($comment)==false && empty($ednum)==true){
            if($pass=="1234"){
	        $sql = $pdo -> prepare("INSERT INTO keijiban (name, comment) VALUES (:name, :comment)");
	        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	        $sql -> execute();
            }
        }
        // 削除機能
        if(empty($dpass)==false&&empty($delete)==false){
            if($dpass=="1234"){
                $id = $delete ;
                $sql = 'delete from keijiban where id=:id';
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	            $stmt->execute();
            }
        }
        // 編集機能
	    if(empty($pass)==false&&empty($ednum)==false&&empty($name)==false&&empty($comment)==false){
	        $id = $ednum; //変更する投稿番号
            $name = $_POST["name"];
            $comment = $_POST["comment"];
	        $sql = 'UPDATE keijiban SET name=:name,comment=:comment WHERE id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();
	    }
        // データレコード表示
        $sql = 'SELECT * FROM keijiban ORDER BY id DESC';
	    $stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	    foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		    echo $row['id'].',';
		    echo ($row['name']).',';
		    echo ($row['comment']).',';
		    echo $date.'<br>';
	        echo "<hr>";
	    }
	    //編集選択 
	    if(empty($epass)==false){
	        if(isset($_POST["edit"])){
	            foreach ($results as $row){
	                if($row['id']==$_POST["edit"]){
	                    $enum = $row['id'];
	                    $ename = $row['name'];
	                    $ecom = $row['comment'];
	                }
	            }
    	    }
	    }
	}catch(PDOException $e){
	    echo 'エラー<br>';
	    echo $e->getMessage();
	    }

?>
    <form action="" method="post"> 
        <!--名前の入力フォーム-->
        【  投稿フォーム  】<br>
        名前：      
        <input type="text" name="name" value="<?php echo $ename;?>" ><br>
        <!--コメントの入力フォーム-->
        コメント:   
        <input type="text" name="comment" value="<?php echo $ecom;?>"><br>
        pass：
        <input type="text" name="pass"><br>
        <input type="hidden" name="number" value="<?php echo $enum;?>">
        <input type="submit" value="投稿"><br><br>
    </form>    
    <form action="" method="post">    
        <!--削除フォーム-->
        【  削除フォーム  】<br>
        投稿番号：
        <input type="number" name="delete"><br> 
        pass：
        <input type="text"  name="dpass"><br>
        <input type="submit" value="削除"><br><br>
    </form>
    <!--編集フォーム-->
    <form action="" method="post">
        【　編集フォーム　】<br>
        投稿番号：
        <input type="number" name="edit" ><br>
        pass：
        <input type="text"  name="epass"><br>
        <input type="submit" value="編集">
    </form>
</body>
</html>