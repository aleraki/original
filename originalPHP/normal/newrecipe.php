<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>新規投稿</title>
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
    if(!isset($_SESSION["User"])){
      header("Location:../login.php");
      exit;
    }
  ?>
  <main>
    <div id="main">
    <h1 id="centerh1">レシピ投稿</h1>
    <form action="newrecipecon.php" method="post" enctype="multipart/form-data">
      <p><span>*</span>タイトル：</p><input type="text" name="title" id="title">
      <p><span>*</span>写真：</p>
      <input type="file" name="input_file" accept="image/*" id="image">
        <div class="preview"></div>
      <p id="matetitle">材料：<span>空欄は作らないでください</span></p>
      <div id="mates">
      <div id="matelist">
      <input type="text" name="mate[name][]" class="mate"><input type="text" name="mate[num][]" class="num">
      </div>
    </div>
    <div id="flex">
    <div id="minas">-</div>
    <div id="plus">+</div>
    </div>
      <p>手順1：</p>
      <textarea name="proce1" class="proce"></textarea>
      <p>手順2：</p>
      <textarea name="proce2" class="proce"></textarea>
      <p>手順3：</p>
      <textarea name="proce3" class="proce"></textarea>
      <p>手順4：</p>
      <textarea name="proce4" class="proce"></textarea>
      <p>手順5：</p>
      <textarea name="proce5" class="proce"></textarea>
      <p>手順6：</p>
      <textarea name="proce6" class="proce"></textarea>
      <p><span>*</span>タグ：</p>
      <select name="type" id="typese">
        <option disabled selected value>種類の選択</option>
        <option value="1">主食</option>
        <option value="2">副菜</option>
        <option value="3">デザート</option>
      </select>
      <select name="age" id="ages">
        <option disabled selected value>月齢の選択</option>
        <option value="1">0-6ヶ月</option>
        <option value="2">7-11ヶ月</option>
        <option value="3">1歳</option>
      </select>
      <input type="submit" value="投稿内容を確認する" id="editcon">
    </form>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
