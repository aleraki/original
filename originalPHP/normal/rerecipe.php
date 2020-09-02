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
  //どっちも入力されてる
  if(!empty($_POST["search"]) && !empty($_POST["age_search"])){
    $finds = $user->searchAll($_POST["search"],$_POST["age_search"]);
    //月齢だけ空
  }elseif(!empty($_POST["search"]) && empty($_POST["age_search"])){
    $finds = $user->searchRecipe($_POST["search"]);
    //月齢だけ入力
  }elseif(empty($_POST["search"]) && !empty($_POST["age_search"])){
    $finds = $user->searchRecipeAge($_POST["age_search"]);
  }
  else{
    header("Location:recipe.php");
    exit;
  }
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
// print_r($finds);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>検索結果</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/recipe.css">
   <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
  <script type="text/javascript" src="../js/jquery.js"></script>
<script>
  $(function(){
    reset();
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
    $(document).on("click",function(e){
      if(!$(e.target).closest("form").length){
      $("#radioform").fadeOut();
      }else{
      $("#radioform").fadeIn();
      }
    });
  });
  function reset() {
    $("#reset").animate({
      "top": "-=7px"
    }, 1500).animate({
      "top": "+=7px"
    }, 1500);
    setTimeout("reset()", 3000);
  }
</script>
</head>
<body>
  <?php
    require_once("../parts/header.php");
  ?>
  <main>
    <div id="main">
      <div id="reset">ここをクリックして検索リセット</div>
    <h1><a href="recipe.php">レシピ一覧</a></h1>
    <a href="newrecipe.php" id="new">投稿する</a>
    <!-- <a href="https://twitter.com/intent/tweet?button_hashtag=yumyum&ref_src=twsrc%5Etfw" class="twitter-hashtag-button" data-show-count="false">Tweet #離乳食</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
    <form action="rerecipe.php" method="post" autocomplete=off>
      <!-- <div id="agediv" class="flex"> -->
        <!-- <form action="rerecipe_age.php" method="post"> -->
          <div id="radioform" class="hidden">
          <label><input type="radio" name="age_search" value="1">0-6ヶ月</label>
          <label><input type="radio" name="age_search" value="2">7-11ヶ月</label>
          <label><input type="radio" name="age_search" value="3">1歳</label>
          <!-- <input type="radio" name="type_search" value="1">主食
          <input type="radio" name="type_search" value="2">副菜
          <input type="radio" name="type_search" value="3">デザート -->
      </div>
          <input type="text" name="search">
          <input type="submit" value="検索" id="search_button">
          <!-- <input type="submit" value="月齢で検索" id="age_button"> -->
      </form>
    <!-- </div> -->
    <p id="result">検索結果</p>
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
          <p><?php print($finds[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?></p>
        </div>
        <?php endif; ?>
        <?php endfor; ?>
        </div>
        </div>
        <?php endfor; ?>
        <?php endif; ?>
        </div>
    </div>
    </div>
    <div id="top" class="hidden"><a href="#"></a>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
