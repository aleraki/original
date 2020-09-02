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
$ref = $_SERVER["HTTP_REFERER"];
$url = "http://localhost:8888/originalPHP/normal/myedit.php";
if(!strstr($ref,$url)){
  header("Location:mypage.php");
  exit();
}
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();
  //編集するボタンが押された
  if($_REQUEST["id"]){
    $user->deleteMyRecipe($_REQUEST["id"]);
  }
    // $finds = $user->menuFirst($_POST["age"]);
    // $age = $_POST["age"];
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>マイレシピ削除</title>
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
    <h1>マイレシピを削除しました</h1>
      <a href="mypage.php" id="deleteicon">マイページへ </a>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
