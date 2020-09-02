<?php
  $host = 'localhost';
  $name = 'yum_db';
  $user = 'root';
  $pass = 'root';

  $user_id = $_POST["user"];
  $recipe = $_POST["recipe"];
  try{
  $db = new PDO("mysql:host={$host};dbname={$name};charset=utf8mb4", $user,$pass);
  }catch (PDOException $e) {
    echo "エラー!: " . $e->getMessage() . "<br/gt;";
    exit;
  }


  $sql = 'INSERT INTO favorite (user_id,recipe_id) VALUES(?,?)';
    $stmt = ($db->prepare($sql));
    $result = $stmt->execute(array($user_id, $recipe));

    header('Content-type: application/json');
    echo json_encode($result);
