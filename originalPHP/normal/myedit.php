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
$ref = $_SERVER["HTTP_REFERER"];
$url = "http://localhost:8888/originalPHP/normal/myrecipeall.php";
if(!strstr($ref,$url)){
  header("Location:mypage.php");
  exit();
}
try{
  $user = new Parts($host,$name,$user,$pass);
  $user->connectDB();
  //編集するボタンが押された
  if($_REQUEST["id"]){
    $result["user"] = $user->recipeEdit($_REQUEST["id"]);
    $mate = $user->mateEdit($_REQUEST["id"]);
    $proce = $user->detailProce($_REQUEST["id"]);
    $recipe = $_REQUEST["id"];
  }
    // $finds = $user->menuFirst($_POST["age"]);
    // $age = $_POST["age"];
}catch (PDOException $e) {
  print "エラー!: " . $e->getMessage() . "<br/gt;";
    die();
}
// print_r($result["user"][0]["age_id"]);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>レシピ編集</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/myedit.css">
  <script type="text/javascript" src="../js/jquery.js"></script>
<script>
  $(function(){
    //input type fileのプレビュー処理
  $('form').on('change', 'input[type="file"]', function(e) {
    var file = e.target.files[0],
        reader = new FileReader(),
        preview = $(".preview");
    reader.onload = (function(file) {
      return function(e) {
        preview.empty();
        preview.append($('<img>').attr({
          src: e.target.result,
          width: "150px",
          class: "preview",
          title: file.name
      }));
      };
    })(file);
    reader.readAsDataURL(file);
  });

  $("#plus").click(function(){
    $("#mates").append('<div id="matelist"><input type="text" name="mate[name][]" class="mate"><input type="text" name="mate[num][]" class="num"></div>');
  });
  $("#minas").click(function(){
    $("#matelist:last").remove();
  });
  $("#draw").click(function(){
      if(!confirm("退会しますか？")){
        return false;
      }else{
        location.href = "draw.php";
      }
    });
    $("#button").click(function(){
      if(!confirm("本当に削除してよろしいですか？")){
        return false;
      }else{
        location.href = "delete.php";
      }
    });
    $("#editcon").on("click",function(){
      if($("#title").val() === ""){
        alert("名前を入力してください");
        return false;
      }
      if($("#image").val() === ""){
        alert("画像を入力してください");
        return false;
      }
      if($(".mate").val() === ""){
        alert("材料名を入力してください");
        return false;
      }
      if($(".num").val() === ""){
        alert("材料の分量を入力してください");
        return false;
      }
      if(!$("#typese").val()){
        alert("種類を入力してください");
        return false;
      }
      if(!$("#ages").val()){
        alert("月齢を入力してください");
        return false;
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
    <h1>レシピ編集</h1>
    <a href="delete.php?id=<?php print($recipe); ?>" id="button">このレシピを削除する</a>
    <form action="editcon.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $_REQUEST["id"]; ?>">
      <p><span>*</span>タイトル：</p><input type="text" name="title" id="title" value="<?php print($result["user"][0]["title"]); ?>">
      <p><span>*</span>写真：</p>
      <input type="file" name="input_file" accept="image/*" id="image">
        <div class="preview"></div>
      <p id="matetitle">材料：<span>空欄は作らないでください</span></p>
      <div id="mates">
      <div id="matelist">
      <?php for($i = 0;$i < count($mate);$i++): ?>
      <input type="text" name="mate[name][]" class="mate" value="<?php print($mate[$i]["mate_name"]); ?>"><input type="text" name="mate[num][]" class="num" value="<?php print($mate[$i]["num"]); ?>">
      <?php endfor; ?>
      </div>
    </div>
    <div id="flex">
    <div id="minas">-</div>
    <div id="plus">+</div>
    </div>
      <p>手順1：</p>
      <textarea name="proce1" class="proce"><?php print($proce[0]["proce_name"]); ?></textarea>
      <p>手順2：</p>
      <textarea name="proce2" class="proce"><?php if(!empty($proce[1]["proce_name"])){print($proce[1]["proce_name"]);}else{print("");} ?></textarea>
      <p>手順3：</p>
      <textarea name="proce3" class="proce"><?php if(!empty($proce[2]["proce_name"])){print($proce[2]["proce_name"]);}else{print("");} ?></textarea>
      <p>手順4：</p>
      <textarea name="proce4" class="proce"><?php if(!empty($proce[3]["proce_name"])){print($proce[3]["proce_name"]);}else{print("");} ?></textarea>
      <p>手順5：</p>
      <textarea name="proce5" class="proce"><?php if(!empty($proce[4]["proce_name"])){print($proce[4]["proce_name"]);}else{print("");} ?></textarea>
      <p>手順6：</p>
      <textarea name="proce6" class="proce"><?php if(!empty($proce[5]["proce_name"])){print($proce[5]["proce_name"]);}else{print("");} ?></textarea>
      <p><span>*</span>タグ：</p>
      <select name="type" id="typese">
        <option disabled selected value>種類の選択</option>
        <option value="1" <?php if($result["user"][0]["type_id"] == 1){ echo "selected"; }?>>主食</option>
        <option value="2"<?php if($result["user"][0]["type_id"] == 2){ echo "selected"; }?>>副菜</option>
        <option value="3"<?php if($result["user"][0]["type_id"] == 3){ echo "selected"; }?>>デザート</option>
      </select>
      <select name="age" id="ages">
        <option disabled selected value>月齢の選択</option>
        <option value="1" <?php if($result["user"][0]["age_id"] == 1){ echo "selected"; }?>>0-6ヶ月</option>
        <option value="2" <?php if($result["user"][0]["age_id"] == 2){ echo "selected"; }?>>7-11ヶ月</option>
        <option value="3" <?php if($result["user"][0]["age_id"] == 3){ echo "selected"; }?>>1歳</option>
      </select>
      <!-- <textarea name="tags" class="tags"></textarea> -->
      <input type="submit" value="編集内容を確認する" id="editcon">
    </form>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
