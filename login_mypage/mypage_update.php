<?php
mb_internal_encoding("utf8");

//セッションスタート
session_start();

//DB接続およびtry catch文
try{
    $pdo=new PDO("mysql:dbname=lesson01;host=localhost;","root","");
}catch(PDOException $e){
    //　PDOExceptionはPDO関連の例外のこと　次の変数は自由に決めてよい
    die(
    "<p>申し訳ございません。現在サーバーが混み合っており一時的にアクセス出来ません。<br>しばらくしてから再度ログインしてください。</p>
    <a href='login.php'>ログイン画面へ</a>"
    );
}

//prepareステートメント（update文で更新）でSQLセット。
$stmt=$pdo->prepare("update login_mypage set name=?,mail=?,password=?,comments=? where id = ? ");
//bindValueでパラメータセット
$stmt->bindValue(1,$_POST["name"]);
$stmt->bindValue(2,$_POST["mail"]);
$stmt->bindValue(3,$_POST["password"]);
$stmt->bindValue(4,$_POST["comments"]);
$stmt->bindValue(5,$_SESSION["id"]);
//executeでクエリ実行
$stmt->execute();

//prepareステートメント（更新された情報をDBからselect文で取得）でSQLセット。
$stmt = $pdo->prepare("select * from login_mypage where mail = ? && password = ?" );
//bindValueメソッドでパラメータセット
$stmt->bindValue(1,$_POST["mail"]);
$stmt->bindValue(2,$_POST["password"]);
//executeでクエリ実行
$stmt->execute();

//データベース切断
$pdo=NULL;

//fetchとwhileでデータ取得、sessionに代入
while($row=$stmt->fetch()){
    $_SESSION['id']=$row['id'];
    $_SESSION['name']=$row['name'];
    $_SESSION['mail']=$row['mail'];
    $_SESSION['password']=$row['password'];
    $_SESSION['picture']=$row['picture'];
    $_SESSION['comments']=$row['comments'];
}

//mypage.phpへリダイレクト
header("Location:mypage.php");

?>