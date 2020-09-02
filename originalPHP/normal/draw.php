<?php
session_start();

require_once("../DB/dbparts.php");
require_once("../DB/parts.php");
require_once("../DB/db.php");
//新規登録、ログインページを経由していなかったら
if(!isset($_SESSION["User"])){
  header("Location:../login.php");
  exit;
}
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();
  //編集するボタンが押された
  $user->deleteUser($_SESSION["User"]["id"]);
  $_SESSION = array();
session_destroy();
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>退会</title>
  <link rel="stylesheet" href="../css/user.css">
  <script type="text/javascript" src="../js/jquery.js"></script>
<script>
  $(function(){
$("#draw").click(function(){
      if(!confirm("退会しますか？")){
        return false;
      }else{
        location.href = "draw.php";
      }
    });
    $("#pulldown").hover(function(){
      $(this).children("ul:not(:animated)").slideDown(400);
    },function(){
      $(this).children("ul:not(:animated)").slideUp(400);
    });
  });
</script>
</head>
<body>
  <header>
    <img src="../img/logo.jpg">
  </header>
  <main>
    <div id="main">
    <h1>退会しました</h1>
      <a href="../login.php" id="deleteicon">ログインページへ</a>
  </main>
    <footer>
    <p>コピーライト</p>
  </footer>
</body>
</html>
