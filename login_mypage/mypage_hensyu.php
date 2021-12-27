<?php
mb_internal_encoding("utf8");

//セッションスタート
session_start();

//mypage.phpからの導線以外は、『login_error.php』へリダイレクト
if(empty($_POST['from_mypage'])){
    header("Location:login_error.php");
}
?>

<!doctype HTML>
<html lang="ja">

<head>
<meta charset="utf-8">
<title>マイページ登録</title>
<link rel="stylesheet" type="text/css" href="mypage_hensyu.css">
</head>

<body>

<header>
    <img src="4eachblog_logo.jpg">
    <div class="logout"><a href="logout.php">ログアウト</a></div>
</header>

<main>
    <div class="box">
        <form action="mypage_update.php" method="post" class="form_center">
            <h2>会員情報</h2>

            <div class="hello">
                <?php echo "こんにちは！　".$_SESSION['name']."さん"; ?>
            </div>

            <div class="profile_pic">
                <img src="<?php echo $_SESSION['picture'];?>">
            </div>

            <div class="basic_info">
                <p>氏名:<input type="text" size="40" value="<?php echo $_SESSION['name'];?>" name="name" required></p>
                <p>メール:<input type="text" size="40" value="<?php echo $_SESSION['mail'];?>"  name="mail" pattern="^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required></p>
                <p>パスワード:<input type="text" size="40" value="<?php echo $_SESSION['password'];?>" name="password" pattern="^[a-zA-Z0-9]{6,}$" required></p>
            </div>

            <div class="comments">
                <textarea rows="5" cols="75" class="textbox" name="comments"> <?php echo $_SESSION['comments'];?> </textarea>
            </div>

            <div class="hensyubutton">
                <input type="submit" class="submit_button" size="35" value="この内容に変更する">
            </div>
        </form>
    </div>
</main>

<footer>
    © 2018 InterNous.inc All rights reserved
</footer>

</body>

</html> 
