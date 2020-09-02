<?php
  session_start();
  ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>献立作成</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/menu.css">
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
    $("#button").on("click",function(){
    if(!$("select").val()){
        alert("月齢を選択してください");
        return false;
      }
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
    if(!isset($_SESSION["User"])){
      header("Location:../login.php");
      exit;
    }
  ?>
  <main>
    <div id="main">
    <h1>こんだて作成</h1>
    <form action="menu1.php" method="post">
      <select name="age">
        <option disabled selected value>月齢の選択</option>
        <option value="1">0-6ヶ月</option>
        <option value="2">7-11ヶ月</option>
        <option value="3">1歳</option>
      </select>
      <input type="submit" value="次へ" id="button">
    </form>
</div>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
