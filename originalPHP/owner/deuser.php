<?php
session_start();

require_once("../DB/dbparts.php");
require_once("../DB/db.php");
require_once("../DB/parts.php");
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();
  if(!isset($_SESSION["User"])){
    header("Location:../login.php");
    exit;
  }
  if(isset($_REQUEST["id"])){
  $user->deleteUser($_REQUEST["id"]);
  }
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
  die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="../css/user.css">
</head>
<body>
  <header>
    <img src="../img/logo.jpg">
  </header>
  <main>
    <div id="main">
    <h1>ユーザを削除しました</h1>
      <a href="ownerpage.php" id="deleteicon">オーナーマイページへ </a>
  </main>
  <footer>
    <p>コピーライト</p>
  </footer>
</body>
</html>
