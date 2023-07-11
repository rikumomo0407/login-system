<?php
// require 'password.php';

// セッション開始
session_start();
 
// エラーメッセージの初期化
$errorMessage = "";
 
// 登録ボタンが押された場合
if (isset($_POST["login"])) {
  // １．ユーザIDの入力チェック
    if (empty($_POST["userid"])) {
        $errorMessage = "ユーザIDが未入力です。";
    } else if (!ctype_alnum($_POST["userid"])) {
        $errorMessage = "ユーザー名は半角英数字で入力してください。";
    } else if (empty($_POST["password"])) {
        $errorMessage = "パスワードが未入力です。";
    }
 
  // ２．ユーザIDとパスワードが入力されていたら認証する
    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {

        // mysqlへの接続
        $mysqli = new mysqli('**********', '**********', '**********');
        if ($mysqli->connect_errno) {
            print('<p>データベースへの接続に失敗しました。</p>' . $mysqli->connect_error);
            exit();
        }
 
        // データベースの選択
        $mysqli->select_db('**********');
 
        // 入力値のサニタイズ
        $userid = $mysqli->real_escape_string($_POST["userid"]);
        $password = $mysqli->real_escape_string($_POST["password"]);
        
        // クエリの実行
        $query = "INSERT INTO db_user (name, password) VALUES ('$userid','$password')";
        $result = $mysqli->query($query);
        if (!$result) {
            $errorMessage = "このユーザー名は既に存在します。";
        } else {
            header("Location: back_to_login");
        }

        // mysqlの終了
        $mysqli->close();
    }
} 
 
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>新規登録</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="logindiv">
            <h1>新規登録画面</h1>
            <!-- $_SERVER['PHP_SELF']はXSSの危険性があるので、actionは空にしておく -->
            <!--<form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">-->
            <form id="loginForm" name="loginForm" action="" method="POST">
                <fieldset>
                    <div id="error"><?php echo $errorMessage ?></div>
                    <label for="userid">ユーザID</label><input type="text" id="userid" name="userid" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>">
                    <br>
                    <label for="password">パスワード</label><input type="password" id="password" name="password" value="">
                    <br>
                    <input type="submit" id="login" name="login" value="登録する">
                </fieldset>
            </form>
        </div>
    </body>
</html>