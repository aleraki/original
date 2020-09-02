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
// $ref = $_SERVER["HTTP_REFERER"];
// $url = "http://localhost:8888/originalPHP/normal/menu2.php";
// if(!strstr($ref,$url)){
//   header("Location:menu.php");
//   exit();
// }
if(empty($_POST["first"]) || empty($_POST["second"])){
  header("Location:menu.php");
  exit();
}
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();
    //デザート
    $finds = $user->menuThird($_POST["age"]);
    //主食で選んだレシピのrecipe_id
    $first = $_POST["first"];
    //主食で選んだレシピのrecipe_id
    $second = $_POST["second"];
    //最初に選んだ月齢
    $age = $_POST["age"];
    // print_r($finds);
    // print_r($first);
    // print_r($second);
    // print_r($age);
    $before = $user->beforeRecipe1($_POST["first"]);
    $before1 = $user->beforeRecipe1($_POST["second"]);
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
// print_r($_POST);

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>献立作成-デザート</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/menu.css">
    <script type="text/javascript" src="../js/jquery.js"></script>
<script>
  $(function(){
      $(".content:nth-child(n + 2)").addClass("hidden");
    //もっとみる
      var num = 1;
      $("#morev").click(function(){
        num ++;
        $(".content:nth-child("+num+")").removeClass("hidden");
      });
    //選択
      $(".recipecon").click(function(){
        if($(this).hasClass("white")){
          $(this).removeClass("white");
          $(".recipecon").removeClass("select");
          $(".recipecon").addClass("white");
          $(this).addClass("select");
        }
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
    $("#button").on("click",function(){
    if(!$("#radio:checked").val()){
        alert("選択してください");
        return false;
      }
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
    <h1>こんだて作成</h1>
    <div class="flex">
    <p class="before"><?php print($before["title"]); ?></p>
    <p class="before"><?php print($before1["title"]); ?></p>
    </div>
      <h2>デザートを選んでください</h2>
      <form action="menu4.php" method="post">
      <?php if(!empty($finds)): ?>
    <?php for($j = 0; $j < count($finds); $j=$j+3): ?>
    <div class="content">
      <div class="flex">
      <?php for($i = $j;$i < $j+3; $i++): ?>
      <?php if(!empty($finds[$i])): ?>
        <div class="recipecon white">
          <label>
          <img src="<?php print($finds[$i]["image"]); ?>">
          <input type="radio" name="third" id="radio" class="hidden"value="<?php print($finds[$i]["id"]); ?>">
          <h2><?php print($finds[$i]["title"]); ?></h2>
          <p><?php print($finds[$i]["GROUP_CONCAT(mate_name SEPARATOR '　' )"]); ?></p>
      <input type="hidden" name="age" value="<?php print($age); ?>">
      <input type="hidden" name="first" value="<?php print($first); ?>">
      <input type="hidden" name="second" value="<?php print($second); ?>">
        </div>
      </label>
        <?php endif; ?>
        <?php endfor; ?>
        </div>
        </div>
        <?php endfor; ?>
      <?php endif; ?>
        <?php if(!empty($finds[3])): ?>
        <button type="button" id="morev">もっとみる</button>
        <?php endif; ?>
        <input type="submit" value="次へ" id="button">
      </form>
      <form action="menu2.php" method="post">
        <input type="hidden" name="age" value="<?php print($age); ?>">
        <input type="hidden" name="first" value="<?php print($first); ?>">
        <input type="submit" value="戻る" id="return">
      </form>
    </div>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
