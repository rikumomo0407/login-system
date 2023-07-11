<?php
session_start();
 
// ログイン状態のチェック
if (!isset($_SESSION["USERID"])) {
    header("Location: logout");
    exit;
}
?>
 
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>サンプルアプリケーション</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="main">
            <h1>ログインに成功しました。</h1>
            <!-- ユーザIDにHTMLタグが含まれても良いようにエスケープする -->
            <p>ようこそ「<?=htmlspecialchars($_SESSION["USERID"], ENT_QUOTES); ?>」さん</p>
            <ul>
                <li><a href="logout">ここからログアウト</a></li>
            </ul>
        </div>
    </body>
</html>