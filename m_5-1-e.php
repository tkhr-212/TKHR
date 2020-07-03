<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>データの挿入</title>
</head>
<body>
    <form action="" method="post"> 
        <!--名前の入力フォーム-->
        【  投稿フォーム  】<br>
        名前：      
        <input type="text" name="namae" value="<?php echo $ename;?>" ><br>
        <!--コメントの入力フォーム-->
        コメント:   
        <input type="text" name="com" value="<?php echo $ecom;?>"><br>
        pass：
        <input type="text" name="pass"><br>
        編集番号：
        <input type="text" name="number" value="<?php echo $enum;?>"><br>
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
<?php
    $name = $_POST("namae");
    $comment = $_POST("com");
	// DB接続設定
	$dsn = 'mysql:dbname=tb220051db;host=localhost';
	$user = 'tb-220051';
	$password = 'Vadtpfeegr';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$name = (string)filter_input( INPUT_POST, "name" );//post送信された投稿者の名前
    $comment = (string)filter_input( INPUT_POST, "comment");//post送信された投稿コメント
    $password = (int)filter_input( INPUT_POST, "password" );//post送信された投稿パスワード
	
	if ( !empty( $name ) && !empty( $comment )){
	$sql = $pdo -> prepare("INSERT INTO keijiban (name, comment) VALUES (:name, :comment)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> execute();
	}
// 	$name = $_POST("namae");
// 	$comment = $_POST("com");
// 	$name = $fname;
// 	$comment = $fcomment; 

    $sql = 'SELECT * FROM keijiban ORDER BY id DESC';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
// 	if(isset($_POST["com"])){
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'].'<br>';
        var_dump($row);
	echo "<hr>";
	}
// 	}

?>
</body>
</html>