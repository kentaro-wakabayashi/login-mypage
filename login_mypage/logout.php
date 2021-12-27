<?php
    //セッションスタート
    session_start();

    //セッションの初期化
    session_destroy();

    //『login.php』にリダイレクト
    header("Location:login.php");
?>