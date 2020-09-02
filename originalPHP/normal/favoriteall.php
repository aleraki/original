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
    $finds = $user->favoriteAll($_SESSION["User"]["id"]);
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>お気に入り一覧</title>
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
    <h1>お気に入り一覧</h1>
    <?php if(!empty($finds)): ?>
    <?php for($j = 0; $j < count($finds); $j=$j+3): ?>
    <div class="content">
      <div class="flex">
      <?php for($i = $j;$i < $j+3; $i++): ?>
      <?php if(!empty($finds[$i])): ?>
        <?php $recipeId = $finds[$i]["id"]; ?>
        <div class="recipecon">
          <a href="detail.php?id=<?php print($finds[$i]["id"]); ?>" class="syosai"></a>
          <img src="<?php print($finds[$i]["image"]); ?>">
          <h2><?php print($finds[$i]["title"]); ?></h2>
          <p><?php print($finds[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?></p>
        <div class="favobutton off">お気に入り解除</div>
        </div>
        <?php endif; ?>
        <?php endfor; ?>
        </div>
        </div>
        <?php endfor; ?>
      <?php else: ?>
        <p id="nofav">お気に入り登録しているレシピはありません</p>
        <?php endif; ?>
        </div>
    </div>
</div>
<?php if(!empty($finds)): ?>
<a href="mypage.php" id="button">マイページへ</a>
<?php else: ?>
<a href="recipe.php" id="button">レシピ一覧へ</a>
<?php endif; ?>
    </div>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
  <script>
    $(function(){
    $(".favobutton").click(function(){
      var recipe = <?php echo $recipeId; ?>;
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
        });
  </script>
</body>
</html>
