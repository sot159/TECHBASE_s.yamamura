<!DOCTYPE html>
<head>
<meta charset="utf-8">
<title>mission_4.php</title>
</head>


<?php
///////////////////////接続///////////////////////////////////
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>
PDO::ERRMODE_WARNING));

/////////////////TABLE作成/////////////////////////////
$sql="CREATE TABLE IF NOT EXISTS mission_4"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date TEXT,"
."pass TEXT"
.");";
$stmt=$pdo->prepare($sql);
$stmt->execute();


////////////////名前・コメントを受信・保存///////////////////////
if(!(empty($_POST['name'])) && !(empty($_POST['comment']))){

///////////編集投稿///////////
if(!(empty($_POST['number']))){

$edit_number=$_POST['number'];
$id=$edit_number;

$name_edited=$_POST['name'];
$comment_edited=$_POST['comment'];
$pass_edit2=$_POST['pass1'];
$date=date("Y/m/d H:i:s");

$sql='update mission_4 set name=:name,comment=:comment,date=:date,pass=:pass where id=:id';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':name',$name_edited,PDO::PARAM_STR);
$stmt->bindParam(':comment',$comment_edited,PDO::PARAM_STR);
$stmt->bindParam(':date',$date,PDO::PARAM_STR);
$stmt->bindParam(':pass',$pass_edit2,PDO::PARAM_STR);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);

$stmt->execute();

}


///////////新規投稿////////////
else{
$sql=$pdo->prepare("INSERT INTO mission_4 (name,comment,date,pass) VALUES(:name,:comment,:date,:pass)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':date',$date,PDO::PARAM_STR);
$sql->bindParam(':pass',$pass1,PDO::PARAM_STR);

$name=$_POST['name'];
$comment=$_POST['comment'];
$date=date("Y/m/d H:i:s");
$pass1=$_POST['pass1'];

$sql->execute();
}

}

/////////////////////削除機能//////////////////////////////////////
if(!(empty($_POST['delete']))){
$delete=$_POST['delete'];
$pass2=$_POST['pass2'];

$id=$delete;
//////正しいパスワードを取得//////
$sql='SELECT*FROM mission_4 where id=:id';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->execute();

foreach($stmt as $row){
$rightpass=$row['pass'];
}

/////////パスワード正解//////
if($pass2===$rightpass){
$sql='delete from mission_4 where id=:id';
$stmt=$pdo->prepare($sql);
$stmt->bindParam(':id',$id,PDO::PARAM_INT);
$stmt->execute();
}

///////パスワード不正解////////
if($pass2!=$rightpass){
echo "パスワードが違います";
}

}

///////////////////////////編集するデータの再送信////////////////////
if(!(empty($_POST['edit']))){
$edit=$_POST['edit'];
$pass3=$POST=$_POST['pass3'];

$id=$edit;

////////正しいパスワードを取得///////
$sql='SELECT*FROM mission_4 where id=:id';
$stmt=$pdo->prepare($sql);
$stmt->bindParam('id',$id,PDO::PARAM_INT);
$stmt->execute();

foreach($stmt as $row){
$name_target=$row['name'];
$comment_target=$row['comment'];
$rightpass=$row['pass'];
}

if($pass3===$rightpass){
$edit_name=$name_target;
$edit_comment=$comment_target;
$pass_edit=$rightpass;
}
////////パスワード不正解///////
if($pass3!=$rightpass){
echo "パスワードが違います";
}

}

/////////////////////入力フォーム/////////////////////////////////
?>

<body>
<h1>mission_4</h1>
<form action="mission_4.php" method="POST">
<input type="text" name="name" placeholder="名前" value="<?php echo $edit_name;?>"><br>
<input type="text" name="comment" placeholder="コメント" value="<?php echo $edit_comment;?>">
<input type="hidden" name="number" value="<?php echo $edit;?>"><br>
<input type="text" name="pass1" placeholder="パスワード" value="<?php echo $pass_edit;?>">
<input type="submit" value="送信"><br>
<br>
<input type="text" name="delete" placeholder="削除対象番号"><br>
<input type="text" name="pass2" placeholder="パスワード">
<input type="submit" value="削除"><br>
<br>
<input type="text" name="edit" placeholder="編集対象番号"><br>
<input type="text" name="pass3" placeholder="パスワード">
<input type="submit" value="編集"><br>
</form>


<?php
//////////////////////表示////////////////////////////////////////
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>
PDO::ERRMODE_WARNING));

$sql='SELECT*FROM mission_4 ORDER BY id';
$stmt=$pdo->query($sql);
$results=$stmt->fetchAll();
foreach($results as $row){
echo $row['id'].' ';
echo $row['name'].' ';
echo $row['comment'].' ';
echo $row['date'].'<br>';
}

?>

</body>
</html>