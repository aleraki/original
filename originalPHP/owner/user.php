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
    $result["User"] = $user->find($_REQUEST["id"]);
    $find = $user->userrecipe($_REQUEST["id"]);
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
  <title>ユーザ詳細</title>
  <!-- <link rel="stylesheet" href="../css/base.css"> -->
  <link rel="stylesheet" href="../css/user.css">
  <script type="text/javascript" src="../js/jquery.js"></script>
<script>
  $(function(){
    $("#derecipe").click(function(){
      if(!confirm("レシピを削除しますか？")){
        return false;
      }else{
        location.href = "derecipe.php";
      }
    });
    $("#delete").click(function(){
      if(!confirm("ユーザを削除しますか？")){
        return false;
      }else{
        location.href = "deuser.php";
      }
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
      <a href="../logout.php" id="logout">ログアウト</a>
    <h1>ユーザ詳細</h1>
    <table>
      <tbody>
        <tr>
        <th>ユーザ名</th>
        <th>フリガナ</th>
        <th>メールアドレス</th>
        <th>パスワード</th>
          <tr>
        <td><p><?php print($result["User"]["name"]); ?></p></td>
        <td><p><?php print($result["User"]["kana"]); ?></p></td>
        <td><p><?php print($result["User"]["mail"]); ?></p></td>
        <td><p><?php print($result["User"]["pass"]); ?></p></td>
      </tr>
      </tbody>
    </table>
    <h2>作成レシピ一覧</h2>
    <table>
      <tbody>
        <tr class="thwidth">
        <th>タイトル</th>
        <th>写真</th>
        <th>月齢</th>
        <th>種類</th>
        <th>　</th>
        </tr>
        <?php foreach($find as $row): ?>
        <tr class="thwidth">
        <td><p><?php print($row["title"]); ?></p></td>
        <td><img src="<?php print($row["image"]); ?>" width="100" height="100"></td>
        <td><p><?php print($row["age_name"]); ?></p></td>
        <td><p><?php print($row["type_name"]); ?></p></td>
        <td><p><a href="derecipe.php?id=<?php print($row["id"]); ?>" id="derecipe">レシピ削除</a></p></td>
      </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php if($result["User"]["role"] == 10): ?>
    <a href="deuser.php?id=<?php print($result["User"]["id"]); ?>" id="delete">このユーザを削除する </a>
    <?php endif; ?>
    </div>
  </main>
  <footer>
    <p>コピーライト</p>
  </footer>
</body>
</html>
