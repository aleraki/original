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
    //献立
    $menu = $user->myMenu($_SESSION["User"]["id"]);
    //お気に入り
    $favos = $user->favoriteAll($_SESSION["User"]["id"]);
    //マイレシピ
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
  <title>マイページ</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/mypage.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
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

    var top = $("#top");
    $(window).scroll(function(){
      if($(this).scrollTop() > 100){
        top.removeClass("hidden");
        top.fadeIn();
      }else{
        top.fadeOut();
      }
    });
    top.click(function(){
      $("body,html").animate({
        scrollTop:0
      },500);
      return false;
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
    <!-- マイこんだて -->
    <?php if(!empty($menu)): ?>
    <div class="content">
      <h1>マイこんだて</h1>
      <a id="createmenu" href="../normal/menu.php">こんだて作成</a>
      <div class="flex">
      <?php for($i = 0;$i < 3; $i++): ?>
      <?php if($menu[$i]["id"] == $menu[0]["first"]): ?>
      <div class="typetag">
        <p class="type">主食</p>
        <div class="recipe">
          <a href="detail.php?id=<?php print($menu[$i]["id"]); ?>" class="syosai1"></a>
          <img src="<?php print($menu[$i]["image"]); ?>">
          <h2><?php print($menu[$i]["title"]); ?></h2>
          <p><?php print($menu[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?></p>
        </div>
      </div>
        <?php elseif($menu[$i]["id"] == $menu[0]["second"]): ?>
      <div class="typetag">
        <p class="type">副菜</p>
        <div class="recipe">
        <a href="detail.php?id=<?php print($menu[$i]["id"]); ?>" class="syosai1"></a>
        <div class="recipe">
          <img src="<?php print($menu[$i]["image"]); ?>">
          <h2><?php print($menu[$i]["title"]); ?></h2>
          <p><?php print($menu[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?></p>
        </div>
      </div>
      </div>
        <?php elseif($menu[$i]["id"] == $menu[0]["third"]): ?>
      <div class="typetag">
        <p class="type">デザート</p>
        <div class="recipe">
        <a href="detail.php?id=<?php print($menu[$i]["id"]); ?>" class="syosai1"></a>
        <div class="recipe">
          <img src="<?php print($menu[$i]["image"]); ?>">
          <h2><?php print($menu[$i]["title"]); ?></h2>
          <p><?php print($menu[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?></p>
        </div>
        </div>
        </div>
        <?php endif; ?>
        <?php endfor; ?>
      </div>
      <a href="menuall.php" id="menumore">もっとみる</a>
    </div>
        <?php endif; ?>
    <!-- お気に入り -->
    <?php if(!empty($favos)): ?>
    <div class="content">
      <h1>お気に入り</h1>
      <div class="flex">
      <?php for($i = 0;$i < 3; $i++): ?>
      <?php if(!empty($favos[$i])): ?>
        <div class="recipecon">
          <a href="detail.php?id=<?php print($favos[$i]["id"]); ?>" class="syosai"></a>
          <img src="<?php print($favos[$i]["image"]); ?>">
          <h2><?php print($favos[$i]["title"]); ?></h2>
          <p>
          <?php print($favos[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?>
          </p>
        </div>
        <?php endif; ?>
        <?php endfor; ?>
        </div>
      <a href="favoriteall.php" id="mymore">もっとみる</a>
    </div>
    <?php endif; ?>
    <!-- マイレシピ -->
      <?php if(!empty($finds)): ?>
    <div class="content">
      <h1>マイレシピ</h1>
      <div class="flex">
      <?php for($i = 0;$i < 3; $i++): ?>
      <?php if(!empty($finds[$i])): ?>
        <div class="recipecon">
          <a href="detail.php?id=<?php print($finds[$i]["id"]); ?>" class="syosai"></a>
          <img src="<?php print($finds[$i]["image"]); ?>">
          <h2><?php print($finds[$i]["title"]); ?></h2>
          <p>
          <?php print($finds[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?>
          </p>
        </div>
        <?php endif; ?>
        <?php endfor; ?>
        </div>
      <a href="myrecipeall.php" id="mymore">もっとみる</a>
    </div>
    <?php endif; ?>
    <?php if(empty($menu) && empty($favos) && empty($finds)): ?>
      <a href="menu.php" class="nomore">こんだてを作成する</a>
      <a href="recipe.php" class="nomore">レシピ一覧へ</a>
      <a href="newrecipe.php" class="nomore">投稿する</a>
    <?php endif; ?>
    <div id="top" class="hidden"><a href="#"></a>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
