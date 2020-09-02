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
  $favRecipe = $_REQUEST["id"];
  $favUser = $_SESSION["User"]["id"];
  if(isset($_REQUEST["id"])){
    $finds = $user->recipeDetail($_REQUEST["id"]);
    $mate = $user->detailMate($_REQUEST["id"]);
    $proce = $user->detailProce($_REQUEST["id"]);
    $favo = $user->favoriteAdd($favUser,$favRecipe);
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
  <title>レシピ詳細</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/detail.css">
  <script type="text/javascript" src="../js/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="../css/lightbox.css" type="text/css" rel="stylesheet" media="all" />
<script>
  $(function(){
    $("#button").click(function(){
      var recipe = <?php echo $_REQUEST["id"]; ?>;
      var user = <?php echo $_SESSION["User"]["id"]; ?>;
      //あか
      if($(this).hasClass("on")){
        $(this).removeClass("on");
        $(this).text("お気に入り解除");
        $(this).addClass("off");
        $.ajax({
          url:'../DB/text.php',
          type:'POST',
          dataType:'json',
          data:{
            "user" : user,
            "recipe" : recipe
          }
        }).done(function(data){
          // alert("登録しました");
        }).fail(function(data){
          alert("失敗");
        });
        //灰色
      }else{
        $(this).removeClass("off");
        $(this).addClass("on");
        $(this).text("お気に入り登録");
        $.ajax({
          url:'../DB/text2.php',
          type:'POST',
          data:{
            "user" : user,
            "recipe" : recipe
          },
          dataType:'json'
        }).done(function(data){
          // alert("解除しました");
        }).fail(function(data){
          alert("失敗");
        });
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
    <h1><?php print($finds[0]["title"]); ?></h1>
    <div id="button" class="<?php if(!empty($favo)){print('off');}else{print('on');} ?>" data-id="<?php print($_REQUEST["id"]); ?>"><?php if(!empty($favo)){print("お気に入り解除"); }else{print("お気に入り登録");} ?></div>
    <a href="<?php print($finds[0]["image"]); ?>" data-lightbox="sample" data-title=""/>
    <img src="<?php print($finds[0]["image"]); ?>" alt="">
    </a>
    <div id="mates">
      <p class="title">材料</p>
      <ul>
      <?php for($i = 0;$i < count($mate);$i++): ?>
      <?php if(!empty($mate[$i]["mate_name"])): ?>
        <li><p class="mate"><?php print($mate[$i]["mate_name"]); ?></p><p class="num"><?php print($mate[$i]["num"]); ?></p></li>
      <?php endif; ?>
      <?php endfor; ?>
      </ul>
    </div>
    <div id="tags">
    <?php if($finds[0]["age_id"] == 1): ?>
    <a>0-6ヶ月</a>
    <?php endif; ?>
    <?php if($finds[0]["age_id"] == 2): ?>
    <a>7-11ヶ月</a>
    <?php endif; ?>
    <?php if($finds[0]["age_id"] == 3): ?>
    <a>1歳</a>
    <?php endif; ?>
    <?php if($finds[0]["type_id"] == 1): ?>
    <a>主食</a>
    <?php endif; ?>
    <?php if($finds[0]["type_id"] == 2): ?>
    <a>副菜</a>
    <?php endif; ?>
    <?php if($finds[0]["type_id"] == 3): ?>
    <a>デザート</a>
    <?php endif; ?>
    </div>
    <p class="title">作り方</p>
    <?php for($i = 0;$i < count($proce);$i++): ?>
    <?php if(!empty($proce[$i]["proce_name"])): ?>
    <div class="pro">
      <?php print($proce[$i]["proce_name"]); ?>
    </div>
    <?php endif; ?>
    <?php endfor; ?>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>


<script src="../js/lightbox.js" type="text/javascript"></script>
</body>
</html>
