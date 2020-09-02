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
    $finds = $user->menuAll($_SESSION["User"]["id"]);
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>こんだて一覧</title>
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
    $(".deletemenu").click(function(){
      if(!confirm("このこんだてを削除しますか？")){
        return false;
      }else{
        location.href = "delete_menu.php.php";
      }
    });
    $(".menusupun").hover(function(){
      $(".deletemenu").css({
        "fontSize":"23px"
      });
      $(".supun").css({
        "width":"107px",
        "height":"107px"
      });
    },function(){
      $(".deletemenu").css({
        "fontSize":"20px",
        "color":"#34AAB8"
      });
      $(".supun").css({
        "width":"100px",
        "height":"100px"
      });
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
    <h1>こんだて一覧</h1>
    <?php if(!empty($finds)): ?>
    <?php for($j = 0; $j < count($finds); $j=$j+3): ?>
      <div class="content menuall">
      <div class="flex menugroup">
        <?php for($i = $j;$i < $j+3; $i++): ?>
          <div class="recipecon hov">
          <a href="detail.php?id=<?php print($finds[$i]["id"]); ?>" class="syosai"></a>
          <img src="<?php print($finds[$i]["image"]); ?>">
          <h2><?php print($finds[$i]["title"]); ?></h2>
          <p><?php print($finds[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?></p>
          <?php if($finds[$i]["id"] == $finds[$i]["first"]): ?>
            <p class="type">主食</p>
            <?php elseif($finds[$i]["id"] == $finds[$i]["second"]): ?>
              <p class="type">副菜</p>
              <?php elseif($finds[$i]["id"] == $finds[$i]["third"]): ?>
                <p class="type">デザート</p>
                <?php endif; ?>
        </div>
        <?php endfor; ?>
      </div>
      <div class="menusupun">
      <img src="../img/supun.png" class="supun"><a href="delete_menu.php?id=<?php print($finds[$j]["menu_id"]); ?>" class="deletemenu">このこんだてを削除する</a>
      </div>
        </div>
        <?php endfor; ?>
        <?php endif; ?>
        </div>
    </div>
</div>
<a href="mypage.php" id="button">マイページへ</a>
    </div>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
