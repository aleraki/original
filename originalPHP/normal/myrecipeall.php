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
    $finds = $user->recipeIcon($_SESSION["User"]["id"]);
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>マイレシピ一覧</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/favall.css">
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
    <h1>マイレシピ一覧</h1>
      <?php if(!empty($finds)): ?>
      <?php for($j = 0; $j < count($finds); $j=$j+3): ?>
    <div class="content">
      <div class="flex">
      <?php for($i = $j;$i < $j+3; $i++): ?>
      <?php if(!empty($finds[$i])): ?>
        <div class="recipecon">
          <a href="detail.php?id=<?php print($finds[$i]["id"]); ?>" class="syosai"></a>
          <img src="<?php print($finds[$i]["image"]); ?>">
          <h2><?php print($finds[$i]["title"]); ?></h2>
          <p>
          <?php print($finds[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?>
          </p>
          <a href="myedit.php?id=<?php print($finds[$i]["id"]); ?>" class="edit">編集する</a>
        </div>
      <?php endif; ?>
        <?php endfor; ?>
        </div>
    </div>
      <?php endfor; ?>
    <?php endif; ?>
</div>
<a href="mypage.php" id="button">マイページへ</a>
    </div>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
