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

  //ログインボタンが押されたらログインメソッドにpostの値を渡す
    if($_POST){
      $user->newrecipe($_POST);
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
  <title>投稿完了</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/delete.css">
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
    $("#resimg").click(function(){
      $("#resmenu").slideDown();
    });
    $("#batu").click(function(){
      $("#resmenu").slideUp();
    });
  });
</script>
</head>
<body>
  <?php
    require_once("../parts/header.php");
  ?>
  <main>
    <div id="main">
    <h1>投稿しました</h1>
      <a href="mypage.php" id="deleteicon">マイページへ </a>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
