<?php
session_start();

require_once("DB/dbparts.php");
require_once("DB/db.php");
require_once("DB/parts.php");
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();

  //ログインボタンが押されたらログインメソッドにpostの値を渡す
    if($_POST){
      //loginからきた一致した情報を代入
      $result = $user->login($_POST);
      // print_r($result);
      //一致した内容が入っていたら
      if(!empty($result)){
        //Userセッションに一致した情報を入れる
        //一致したデータがあったら(1がtrue、0がfalse)
        if($result["flag"] == 0){
        $message = "ログインできませんでした";
          header('Location:login.php');
          exit;
        }
        // if($user->login($_POST)){
          //ログインできたら遷移する]
          //もし退会済みだったら
          //もし一般ユーザだったら
          if($result["role"] == 10){
            $_SESSION["User"] = $result;
            header('Location:normal/mypage.php');
            exit;
          //もし管理者だったら
          }else{
            $_SESSION["User"] = $result;
            header('Location:owner/ownerpage.php');
            exit;
        }
      }else{
        $message = "ログインできませんでした";
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
  <title>ログイン</title>
  <!-- <link rel="stylesheet" href="css/base.css"> -->
  <link rel="stylesheet" href="css/login.css">
  <script type="text/javascript" src="../js/jquery.js"></script>
<script>
  $(function(){

  });
</script>
</head>
<body>
  <header>
    <img src="img/logo.jpg">
  </header>
  <main>
    <div id="main">
  <p id="mainp">ユーザ名とパスワードを入力してください</p><br>
  <?php if(isset($message)) echo "<p class='red'>".$message."</p>" ?>
  <form action="" method="post">
    <label>ユーザ名：　<input type="text" name="name" id="nameinput"></label><br>

    <label>パスワード：<input type="password" name="pass" id="passinput"></label><br>

    <input type="submit" value="ログイン" id="button">
  </form>
  <a href="normal/newuser.php">新規登録はこちら</a>
    </div>
  </main>
  <footer>
    <p>コピーライト</p>
  </footer>
</body>
</html>
