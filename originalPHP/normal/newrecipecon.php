<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>新規投稿確認</title>
  <link rel="stylesheet" href="../css/base.css">
  <link rel="stylesheet" href="../css/myeditcon.css">
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
    //投稿画面から来なかったら
    if(!isset($_SESSION["User"])){
      header("Location:../login.php");
      exit;
    }
    $ref = $_SERVER["HTTP_REFERER"];
    $url = "http://localhost:8888/originalPHP/normal/newrecipe.php";
    if(!strstr($ref,$url)){
      header("Location:newrecipe.php");
      exit();
    }
     $fileTempName = $_FILES['input_file']['tmp_name'];
      $fileName = $_FILES['input_file']['name'];
      $attachedFile = "";
        if(!empty($fileTempName)) {
          //ファイルアップロード、tmp_name,アップロード先(attachmentフォルダ)
        $isUploaded = move_uploaded_file($fileTempName, '../attachment/'.$fileName);
        if($isUploaded) {
          $attachedFile = $fileName;
        }
        }
        function h($str){
          return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
        }
  ?>
  <main>
    <div id="main">
    <h1>この内容で投稿してよろしいですか</h1>
    <form action="newconplete.php" method="post">
    <input type="hidden" name="id" value="<?= $_SESSION["User"]["id"]; ?>">
      <p class="titlep">タイトル：</p><p class="sub"><?= h($_POST["title"]); ?></p><input type="hidden" name="title" id="title" value="<?= $_POST["title"]; ?>">
      <p class="titlep">写真：<img src="../attachment/<?php echo $attachedFile; ?>" id="preview"></p><br>
      <input type="hidden" name="input_file" value="../attachment/<?= $attachedFile ?>">
        <div class="preview"></div>
      <p id="matetitle" class="titlep">材料：</p>
      <?php for($i = 0;$i < count($_POST["mate"]["name"]); $i++): ?>
      <p class="sub"><?= h($_POST["mate"]["name"][$i]); ?><?= h($_POST["mate"]["num"][$i]); ?></p>
      <input type="hidden" name="mate[name][]" value="<?= $_POST['mate']['name'][$i]; ?>">
      <input type="hidden" name="mate[num][]" value="<?= $_POST['mate']['num'][$i]; ?>">
      <?php endfor; ?>
      <p class="titlep">手順1：</p><p class="sub"><?= h($_POST["proce1"]); ?></p>
      <input type="hidden" name="proce1" value="<?= $_POST["proce1"]; ?>">
      <?php if(!empty($_POST["proce2"])): ?>
      <p class="titlep">手順2：</p><p class="sub"><?= h($_POST["proce2"]); ?></p>
      <input type="hidden" name="proce2" value="<?= $_POST["proce2"]; ?>">
      <?php endif; ?>
      <?php if(!empty($_POST["proce3"])): ?>
      <p class="titlep">手順3：</p><p class="sub"><?= h($_POST["proce3"]); ?></p>
      <input type="hidden" name="proce3" value="<?= $_POST["proce3"]; ?>">
      <?php endif; ?>
      <?php if(!empty($_POST["proce4"])): ?>
      <p class="titlep">手順4：</p><p class="sub"><?= h($_POST["proce4"]); ?></p>
      <input type="hidden" name="proce4" value="<?= $_POST["proce4"]; ?>">
      <?php endif; ?>
      <?php if(!empty($_POST["proce5"])): ?>
      <p class="titlep">手順5：</p><p class="sub"><?= h($_POST["proce5"]); ?></p>
      <input type="hidden" name="proce5" value="<?= $_POST["proce5"]; ?>">
      <?php endif; ?>
      <?php if(!empty($_POST["proce6"])): ?>
      <p class="titlep">手順6：</p><p class="sub"><?= h($_POST["proce6"]); ?></p>
      <input type="hidden" name="proce6" value="<?= $_POST["proce6"]; ?>">
      <?php endif; ?>
      <?php if($_POST["age"] == 1): ?>
      <p class="sub">0-6ヶ月</p>
      <?php elseif($_POST["age"] == 2): ?>
      <p class="sub">7-11ヶ月</p>
      <?php elseif($_POST["age"] == 3): ?>
      <p class="sub">1歳</p>
      <?php endif; ?>
      <input type="hidden" name="age" value="<?= $_POST["age"]; ?>">
      <?php if($_POST["type"] == 1): ?>
      <p class="sub">主食</p>
      <?php elseif($_POST["type"] == 2): ?>
      <p class="sub">副菜</p>
      <?php elseif($_POST["type"] == 3): ?>
      <p class="sub">デザート</p>
      <?php endif; ?>
      <input type="hidden" name="type" value="<?= $_POST["type"]; ?>">
      <a href="newrecipe.php" id="button">戻る</a>
      <input type="submit" value="登録" id="editcon">
    </form>
  </main>
  <?php
    require_once("../parts/footer.php");
  ?>
</body>
</html>
