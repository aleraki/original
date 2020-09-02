<?php
header("Content-Type: application/json; charset=UTF-8");
  $host = 'localhost';
  $name = 'yum_db';
  $user = 'root';
  $pass = 'root';

  try{
  $db = new PDO('mysql:dbname='.$name.';host='.$host.';charset=utf8',$user,$pass);
}catch (PDOException $e) {
  echo "エラー!: " . $e->getMessage() . "<br/gt;";
  exit;
}
$recipe = $_POST["recipe"];
$user_id = $_POST["user"];
$sql = 'DELETE FROM favorite WHERE user_id=? AND recipe_id=?';
    $stmt = $db->prepare($sql);
    $result = $stmt->execute(array($user_id, $recipe));
    header('Content-type: application/json');
    echo json_encode($result);
