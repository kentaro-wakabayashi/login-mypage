<?php
mb_internal_encoding("utf8");

//セッションスタート
session_start();

if(empty($_SESSION['id'])){
    try{
        //DB接続
        $pdo=new PDO("mysql:dbname=lesson01;host=localhost;","root","");
    }catch(PDOException $e){
        //　PDOExceptionはPDO関連の例外のこと　次の変数は自由に決めてよい
        die(
            "<p>申し訳ございません。現在サーバーが混み合っており一時的にアクセス出来ません。<br>しばらくしてから再度ログインしてください。</p>
            <a href='login.php'>ログイン画面へ</a>"
        );
    }

    //prepared statementでSQL文の型を作る（DBとpostデータ照合。select文とwhere句使用）
    $stmt = $pdo->prepare("select * from login_mypage where mail = ? && password = ?");
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

    //データ取得できず（emptyで判定）sessionがなければリダイレクト（エラー画面へ）
    if(empty($_SESSION['id'])){
        header("Location:login_error.php");
    }

    //「ログイン状態を保持する」にチェックが入っている場合、postされたkeep_loginの値をセッションに保存
    if(!empty($_POST['keep_login'])){
        $_SESSION['keep_login']=$_POST['keep_login'];
    }
}

//ログインに成功かつ$_SESSION['keep_login']が空でない場合、Cookieに保存
if(!empty($_SESSION['id']) && !empty($_SESSION['keep_login'])){
    setcookie('mail',$_SESSION['mail'],time()+60*60*24*7);
    setcookie('password',$_SESSION['password'],time()+60*60*24*7);
    setcookie('keep_login',$_SESSION['keep_login'],time()+60*60*24*7);
}else if(empty($_SESSION['keep_login'])){
    //チェックが入っていない時はクッキーを削除している
    setcookie('mail','',time()-1);
    setcookie('password','',time()-1);
    setcookie('keep_login','',time()-1);
}

?>

<!doctype HTML>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>マイページ登録</title>
<link rel="stylesheet" type="text/css" href="mypage.css">
</head>

<body>

<header>
    <img src="4eachblog_logo.jpg">
    <div class="logout"><a href="logout.php">ログアウト</a></div>
</header>

<main>
    <div class="box">
        <h2>会員情報</h2>

        <div class="hello">
            <?php echo "こんにちは！　".$_SESSION['name']."さん"; ?>
        </div>

        <div class="profile_pic">
            <img src="<?php echo $_SESSION['picture'];?>">
        </div>

        <div class="basic_info">
            <p>氏名:<?php echo $_SESSION['name'];?></p>
            <p>メール:<?php echo $_SESSION['mail'];?></p>
            <p>パスワード:<?php echo $_SESSION['password'];?></p>
        </div>

        <div class="comments">
            <?php echo $_SESSION['comments']; ?>
        </div>

        <form action="mypage_hensyu.php" method="post" class="form_center">
            <input type="hidden" value="<?php echo rand(1,10);?>" name="from_mypage">
            <div class="hensyubutton">
                <input type="submit" class="submit_button" size="35" value="編集する">
            </div>
        </form>
    </div>
</main>

<footer>
    © 2018 InterNous.inc All rights reserved
</footer>

</body>

</html>
