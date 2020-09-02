<?php
session_start();

require_once("DB/dbparts.php");
require_once("DB/db.php");
require_once("DB/parts.php");

$_SESSION = array();
session_destroy();
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();

}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
  die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログアウト</title>
  <link rel="stylesheet" href="css/user.css">
</head>
<body>
  <header>
    <img src="img/logo.jpg">
  </header>
  <main>
    <div id="main">
    <h1>ログアウトしました</h1>
      <a href="login.php" id="deleteicon">ログイン画面へ</a>
  </main>
  <footer>
    <p>コピーライト</p>
  </footer>
</body>
</html>
