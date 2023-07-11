<?php
// require 'password.php';
// セッション開始
session_start();
 
// エラーメッセージの初期化
$errorMessage = "";
 
// ログインボタンが押された場合
if (isset($_POST["login"])) {
  // １．ユーザIDの入力チェック
  if (empty($_POST["userid"])) {
    $errorMessage = "ユーザIDが未入力です。";
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
 
    // クエリの実行
    $query = "SELECT * FROM db_user WHERE name = '" . $userid . "'";
    $result = $mysqli->query($query);
    if (!$result) {
      print('クエリーが失敗しました。' . $mysqli->error);
      $mysqli->close();
      exit();
    }
 
    while ($row = $result->fetch_assoc()) {
      // パスワード(暗号化済み）の取り出し
      $db_hashed_pwd = $row['password'];
    }
 
    // データベースの切断
    $mysqli->close();
 
    // ３．画面から入力されたパスワードとデータベースから取得したパスワードのハッシュを比較します。
    //if ($_POST["password"] == $pw) {
    if ($_POST["password"] == $db_hashed_pwd) {
      // ４．認証成功なら、セッションIDを新規に発行する
      session_regenerate_id(true);
      $_SESSION["USERID"] = $_POST["userid"];
      header("Location: main");
      exit;
    } 
    else {
      // 認証失敗
      $errorMessage = "ユーザIDあるいはパスワードに誤りがあります。";
    } 
  } else {
    // 未入力なら何もしない
  } 
} 
 
?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ログイン画面</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div id="logindiv">
            <h1>ログイン</h1>
            <!-- $_SERVER['PHP_SELF']はXSSの危険性があるので、actionは空にしておく -->
            <!--<form id="loginForm" name="loginForm" action="<?php print($_SERVER['PHP_SELF']) ?>" method="POST">-->
            <form id="loginForm" name="loginForm" action="" method="POST">
                <fieldset>
                    <div id="error"><?php echo $errorMessage ?></div>
                    <label for="userid">ユーザID</label><input type="text" id="userid" name="userid" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>">
                    <br>
                    <label for="password">パスワード</label><input type="password" id="password" name="password" value="">
                    <br>
                    <input type="submit" id="login" name="login" value="ログイン">
                </fieldset>
            </form>
            アカウントをお持ちでない方は<a href="create_account">登録</a>
        </div>
    </body>
</html>