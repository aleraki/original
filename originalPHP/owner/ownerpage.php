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
    exit();
    return;
  }
  $contacts = $user->allfind();
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
  die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>管理者ページ</title>
  <link rel="stylesheet" href="../css/owner.css">
</head>
<body>
   <header>
    <img src="../img/logo.jpg">
  </header>
  <main>
    <div id="main">
      <a href="../logout.php" id="logout">ログアウト</a>
    <h1>ユーザ一覧</h1>
    <table>
      <tbody>
        <tr>
        <th>ユーザ名</th>
        <th>フリガナ</th>
        <th>メールアドレス</th>
        <th>パスワード</th>
        <th>　</th>
        </tr>
        <tr>
          <?php foreach($contacts as $contact): ?>
        <td><p><a href="user.php?id=<?php print($contact["id"]); ?>"><?php print($contact["name"]); ?></a></p></td>
        <td><p><?php print($contact["kana"]); ?></p></td>
        <td><p><?php print($contact["mail"]); ?></p></td>
        <td><p><?php print($contact["pass"]); ?></p></td>
        <td><p><?php if($contact["flag"] == 0){ print("退会"); } ?></p></td>
        </tr>
          <?php endforeach; ?>
      </tbody>
    </table>
    </div>
  </main>
    <footer>
    <p>コピーライト</p>
  </footer>
</body>
</html>
