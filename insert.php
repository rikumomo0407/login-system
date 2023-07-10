<html>
  <meta charset="UTF-8">
  <head>
    <title>ログインユーザー追加ページ</title>
  </head>
  <body>
<?php
$link = mysqli_connect('ホスト名', 'ユーザー名', 'パスワード');
if (!$link) {
    die('接続失敗です。'.mysqli_error());
}
 
$db_selected = mysqli_select_db($link, 'データベース名');
if (!$db_selected){
    die('データベース選択失敗です。'.mysqli_error());
}
 
mysqli_set_charset($link, 'utf8');
 
$result = mysqli_query($link, 'SELECT name,password FROM テーブル名');
if (!$result) {
    die('SELECTクエリーが失敗しました。'.mysqli_error());
}
 
$name = $_POST['name'];
$password = $_POST['password'];
 
$sql = "INSERT INTO テーブル名 (name, password) VALUES ('$name','$password')";
$result_flag = mysqli_query($link, $sql);
 
if (!$result_flag) {
    die('INSERTクエリーが失敗しました。すでに同じNAMEが登録されている可能性があります。<br><a href="add.html">戻る</a>');
}
 
print('<p>' . $name . 'ユーザーを登録しました。</p>');
 
$close_flag = mysqli_close($link);
 
?>
  <a href="add.html">戻る</a>
  </body>
</html>