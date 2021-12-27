<?php
mb_internal_encoding("utf8");
$pdo=new PDO("mysql:dbname=lesson01;host=localhost;","root","");
//プリペアードステートメントでSQL文の型を作る
$stmt=$pdo->prepare("insert into login_mypage(name,mail,password,picture,comments) values(?,?,?,?,?)");
// 上はテーブルのカラム数によって?の数を変える

//bindValueを使用し、実際に各カラムに何をInsertするか記述
$stmt->bindValue(1,$_POST['name']);
$stmt->bindValue(2,$_POST['mail']);
$stmt->bindValue(3,$_POST['password']);
$stmt->bindValue(4,$_POST['path_filename']);
$stmt->bindValue(5,$_POST['comments']);
//excuteでクエリを実行
$stmt->execute();
$pdo=NULL;
//セキュリティ上必ずDBから切断

header('Location:after_register.html');
?>