<?php
session_start();

require_once("../DB/dbparts.php");
require_once("../DB/db.php");
require_once("../DB/parts.php");
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();
  if($_POST){
    $message = $user->validate($_POST);
    if(empty($message["name"]) && empty($message["kana"]) && empty($message["mail"]) && empty($message["pass"])){
      $result = $user->add($_POST);
      $_SESSION["User"] = $result;
      header("Location:mypage.php");
    }
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
  <title>新規登録</title>
  <!-- <link rel="stylesheet" href="../css/base.css"> -->
  <link rel="stylesheet" href="../css/newuser.css">
</head>
<body>
  <header>
    <img src="../img/logo.jpg">
  </header>
  <main>
    <div id="main">
  <p id="title">新規登録</p>
  <form action="" method="post">
    <label><p>お名前を入力してください</p><input type="text" name="name"></label><br>
    <?php if(isset($message["name"])) echo "<p class='red'>".$message["name"]."</p>" ?><br>
    <label><p>フリガナを入力してください</p><input type="text" name="kana"></label><br>
    <?php if(isset($message["kana"])) echo "<p class='red'>".$message["kana"]."</p>" ?><br>
    <label><p>メールアドレスを入力してください</p><input type="mail" name="mail"></label><br>
    <?php if(isset($message["mail"])) echo "<p class='red'>".$message["mail"]."</p>" ?><br>
    <label><p>パスワードを入力してください</p><input type="password" name="pass"></label><br>
    <?php if(isset($message["pass"])) echo "<p class='red'>".$message["pass"]."</p>" ?><br>
    <input type="submit" value="登録" id="button">
  </form>
    </div>
  </main>
  <footer>
    <p>コピーライト</p>
  </footer>
</body>
</html>
