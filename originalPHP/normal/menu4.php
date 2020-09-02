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
$url = "http://localhost:8888/originalPHP/normal/menu3.php";
if(!strstr($ref,$url)){
  header("Location:menu.php");
  exit();
}
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();
  if(isset($_SESSION["User"]["id"],$_POST["first"],$_POST["second"],$_POST["third"],$_POST["age"])){
    //user_id
    $userId = $_SESSION["User"]["id"];
    //副菜
    // $finds = $user->menuThird($_POST["age"]);
    //主食で選んだレシピのrecipe_id
    $first = $_POST["first"];
    //副菜で選んだレシピのrecipe_id
    $second = $_POST["second"];
    //デザートで選んだレシピのrecipe_id
    $third = $_POST["third"];
    $user->menu($userId,$first,$second,$third);
  }else{
    header("Location:../login.php");
    exit;
  }
  // print_r($_POST["first"]);
  // print_r($_POST["second"]);
  // print_r($_POST["third"]);
    // print_r($_SESSION["User"]["id"]);
    // print_r($first);
    // print_r($second);
    // print_r($age);
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>献立作成完了</title>
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
    <h1>献立を作成しました</h1>
      <a href="mypage.php" id="deleteicon">マイページへ </a>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
