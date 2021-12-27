<?php
    mb_internal_encoding("utf8");

    //セッションスタート
    session_start();

    //ログイン時にアクセスした場合は、『mypage.php』にリダイレクト
    if(isset($_SESSION['id'])){
        header("Location:mypage.php");
    }
?>

<!doctype HTML>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>ログインページ</title>
<link rel="stylesheet" type="text/css" href="login.css">
</head>

<body>

<header>
    <img src="4eachblog_logo.jpg">
    <div class="login"><a href="login.php">ログイン</a></div>
</header>
 
<main>
    <form action="mypage.php" method="post">
        <div class="login_mydata">
            <div class="mail">
                <label>メールアドレス</label><br>
                <input type="text" size="40" value="<?php if(isset($_COOKIE['keep_login'])){echo $_COOKIE['mail'];} ?>" name="mail">
            </div>

            <div class="password">
                <label>パスワード</label><br>
                <input type="text" size="40" value="<?php if(isset($_COOKIE['keep_login'])){echo $_COOKIE['password'];} ?>" name="password">
            </div>

            <div class="keep_login">
                <label><input type="checkbox" name="keep_login" value="keep_login" <?php if(isset($_COOKIE['keep_login'])){echo "checked='checked' ";}?> >ログイン状態を保持する。</label>
            </div>

            <div class="submit_login">
                <input type="submit" class="button" size="35" name="submit_login" value="ログイン" >
            </div>
        </div>
    </form>
</main>

<footer>
    © 2018 InterNous.inc All rights reserved
</footer>

</body>

</html>