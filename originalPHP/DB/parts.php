<?php
require_once("db.php");
  class Parts extends DB{

    //ログインメソッド
    public function login($post){
      //DBにフォームの値を参照する
      $sql = 'SELECT * FROM users WHERE name = :name AND pass = :pass';
      $stmt = $this->connect->prepare($sql);
      $params = array(':name' => $post["name"],':pass' => $post["pass"]);
      $stmt->execute($params);
      //参照して一致しているデータの数を$resultに代入
      // $result = $stmt->rowCount();
      //ユーザーの情報を取得する、一致したデータが入る
      $result = $stmt->fetch();
      return $result;
    }
    //新規登録メソッド
    public function add($post){
      $sql = 'INSERT INTO users SET name=?,kana=?,mail=?,pass=?,role=?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post["name"],$post["kana"],$post["mail"],$post["pass"],10);
      $stmt->execute($param);
    }
    //新規レシピ投稿
    //recipeテーブル登録、
    public function newrecipe($post){
      $sql = 'INSERT INTO recipe SET title=?,image=?,type_id=?,age_id=?,user_id=?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post["title"],$post["input_file"],$post["type"],$post["age"],$post["id"]);
      $aaa = $stmt->execute($param);
      //proceテーブル登録
      if(isset($post["proce1"])){
        $sql1 = 'INSERT INTO proce SET proce_name=?,recipe_id=LAST_INSERT_ID(),sort=1';
        $stmt1 = $this->connect->prepare($sql1);
        $param1 = array($post["proce1"]);
        $stmt1->execute($param1);
      }
      if(isset($post["proce2"])){
      $sql2 = 'INSERT INTO proce SET proce_name=?,recipe_id=LAST_INSERT_ID(),sort=2';
      $stmt2 = $this->connect->prepare($sql2);
      $param2 = array($post["proce2"]);
      $stmt2->execute($param2);
      }
      if(isset($post["proce3"])){
      $sql3 = 'INSERT INTO proce SET proce_name=?,recipe_id=LAST_INSERT_ID(),sort=3';
      $stmt3 = $this->connect->prepare($sql3);
      $param3 = array($post["proce3"]);
      $stmt3->execute($param3);
      }
      if(isset($post["proce4"])){
      $sql4 = 'INSERT INTO proce SET proce_name=?,recipe_id=LAST_INSERT_ID(),sort=4';
      $stmt4 = $this->connect->prepare($sql4);
      $param4 = array($post["proce4"]);
      $stmt4->execute($param4);
      }
      if(isset($post["proce5"])){
      $sql5 = 'INSERT INTO proce SET proce_name=?,recipe_id=LAST_INSERT_ID(),sort=5';
      $stmt5 = $this->connect->prepare($sql5);
      $param5 = array($post["proce5"]);
      $stmt5->execute($param5);
      }
      if(isset($post["proce6"])){
      $sql6 = 'INSERT INTO proce SET proce_name=?,recipe_id=LAST_INSERT_ID(),sort=6';
      $stmt6 = $this->connect->prepare($sql6);
      $param6 = array($post["proce6"]);
      $stmt6->execute($param6);
      }
      //mateテーブル登録
      for($i = 0;$i < count($post["mate"]["name"]); $i++){
      $sql7 = 'INSERT INTO mate SET mate_name=?,num=?,recipe_id=LAST_INSERT_ID()';
      $stmt7 = $this->connect->prepare($sql7);
        $param7 = array($post["mate"]["name"][$i],$post["mate"]["num"][$i]);
        $stmt7->execute($param7);
      }
    }
    //マイレシピ編集
    //recipeテーブル登録、
    public function editRecipe($post){
      $sql = 'UPDATE recipe SET title=?,image=?,type_id=?,age_id=?,user_id=? WHERE recipe.id = ?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post["title"],$post["input_file"],$post["type"],$post["age"],$post["id"],$post["recipe"]);
      $aaa = $stmt->execute($param);
      //proceテーブル登録
      if(isset($post["proce1"])){
        $sql1 = 'UPDATE proce SET proce_name=?,recipe_id=? WHERE recipe_id=? AND sort=1';
        $stmt1 = $this->connect->prepare($sql1);
        $param1 = array($post["proce1"],$post["recipe"],$post["recipe"]);
        $stmt1->execute($param1);
      }
      if(isset($post["proce2"])){
      $sql2 = 'UPDATE proce SET proce_name=?,recipe_id=? WHERE recipe_id=? AND sort=2';
      $stmt2 = $this->connect->prepare($sql2);
      $param2 = array($post["proce2"],$post["recipe"],$post["recipe"]);
      $stmt2->execute($param2);
      }
      if(isset($post["proce3"])){
      $sql3 = 'UPDATE proce SET proce_name=?,recipe_id=? WHERE recipe_id=? AND sort=3';
      $stmt3 = $this->connect->prepare($sql3);
      $param3 = array($post["proce3"],$post["recipe"],$post["recipe"]);
      $stmt3->execute($param3);
      }
      if(isset($post["proce4"])){
      $sql4 = 'UPDATE proce SET proce_name=?,recipe_id=? WHERE recipe_id=? AND sort=4';
      $stmt4 = $this->connect->prepare($sql4);
      $param4 = array($post["proce4"],$post["recipe"],$post["recipe"]);
      $stmt4->execute($param4);
      }
      if(isset($post["proce5"])){
      $sql5 = 'UPDATE proce SET proce_name=?,recipe_id=? WHERE recipe_id=? AND sort=5';
      $stmt5 = $this->connect->prepare($sql5);
      $param5 = array($post["proce5"],$post["recipe"],$post["recipe"]);
      $stmt5->execute($param5);
      }
      if(isset($post["proce6"])){
      $sql6 = 'UPDATE proce SET proce_name=?,recipe_id=? WHERE recipe_id=? AND sort=6';
      $stmt6 = $this->connect->prepare($sql6);
      $param6 = array($post["proce6"],$post["recipe"],$post["recipe"]);
      $stmt6->execute($param6);
      }
      //mateをいったん削除
      $sql7 = 'DELETE FROM mate WHERE recipe_id = ?';
      $stmt7 = $this->connect->prepare($sql7);
        $param7 = array($post["recipe"]);
        $stmt7->execute($param7);
      //mateを全部入れる
      for($i = 0;$i < count($post["mate"]["name"]); $i++){
      $sql8 = 'INSERT INTO mate SET mate_name=?,num=?,recipe_id=?';
      $stmt8 = $this->connect->prepare($sql8);
        $param8 = array($post["mate"]["name"][$i],$post["mate"]["num"][$i],$post["recipe"]);
        $stmt8->execute($param8);
      }
    }
    //レシピ編集のための詳細
    public function recipeEdit($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image,mate_name,num,proce_name,sort , type_id,age_id FROM recipe JOIN mate ON mate.recipe_id = recipe.id JOIN proce ON proce.recipe_id = recipe.id WHERE recipe.id = ?";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //レシピ編集のための詳細、材料
    public function mateEdit($post){
      $sql = "SELECT mate.recipe_id,mate_name,num FROM mate WHERE recipe_id = ?";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //レシピ削除
    public function deleteMyRecipe($post){
      $sql = 'DELETE FROM recipe WHERE id=?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $sql1 = 'DELETE FROM proce WHERE recipe_id=?';
      $stmt1 = $this->connect->prepare($sql1);
      $param1 = array($post);
      $stmt1->execute($param1);
      $sql2 = 'DELETE FROM mate WHERE recipe_id = ?';
      $stmt2 = $this->connect->prepare($sql2);
      $param2 = array($post);
      $stmt2->execute($param2);
    }
    //こんだて削除
    public function deleteMyMenu($post){
      $sql = 'DELETE FROM menu WHERE menu_id=?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
    }
    //お気に入り確認
    public function favoriteAdd($user,$recipe){
      $sql = 'SELECT * FROM favorite WHERE user_id=? AND recipe_id=?';
      $stmt = $this->connect->prepare($sql);
      $param = array($user,$recipe);
      $stmt->execute($param);
      $result = $stmt->fetch();
      return $result;
    }
    //お気に入り一覧
    public function favoriteAll($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image, GROUP_CONCAT(mate_name SEPARATOR '　' ),favorite.user_id
            FROM favorite
            JOIN recipe ON favorite.recipe_id = recipe.id
            JOIN mate ON mate.recipe_id = favorite.recipe_id
            WHERE favorite.user_id = ?
            GROUP BY favorite.recipe_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //ユーザ全部参照
    public function allfind(){
      $sql = 'SELECT * FROM users';
      $stmt = $this->connect->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }
    //ユーザ送られてきたデータのみ
    public function find($post){
      $sql = 'SELECT * FROM users WHERE id = ?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetch();
      return $result;
    }
    //ユーザ削除、退会
    public function deleteUser($post){
      $sql = 'UPDATE users SET flag=0 WHERE id=?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
    }
    //ユーザ詳細のユーザの作成レシピ一覧
    public function userrecipe($post){
      $sql = 'SELECT recipe.id,recipe.title,recipe.image, ages.age_name,types.type_name
            FROM recipe
            JOIN ages ON ages.id = recipe.age_id
            JOIN types ON types.id = recipe.type_id
            WHERE user_id = ?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //マイページのマイレシピ
    public function recipeIcon($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image, GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id
            WHERE user_id = ?
            GROUP BY recipe_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //全レシピ一覧
    public function allRecipe($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image, GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id
            GROUP BY recipe_id";
      $stmt = $this->connect->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }
    //menu1、レシピ一覧
    public function menuFirst($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image, recipe.type_id,GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id
            WHERE recipe.age_id = ? AND recipe.type_id = 1
            GROUP BY recipe_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //menu2、レシピ一覧
    public function menuSecond($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image, GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id
            WHERE recipe.age_id = ? AND recipe.type_id = 2
            GROUP BY recipe_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //menu3、レシピ一覧
    public function menuThird($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image, GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id
            WHERE recipe.age_id = ? AND recipe.type_id = 3
            GROUP BY recipe_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //こんだて作成
    public function menu($userId,$first,$second,$third){
      $sql = "INSERT INTO menu SET user_id = ?, first = ? , second = ? , third = ?";
      $stmt = $this->connect->prepare($sql);
      $param = array($userId,$first,$second,$third);
      $stmt->execute($param);
      // $result = $stmt->fetchAll();
    }
    //マイページの献立
    public function myMenu($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image ,GROUP_CONCAT(mate_name SEPARATOR '　' ) ,menu.first,menu.second,menu.third FROM recipe JOIN mate ON mate.recipe_id = recipe.id JOIN menu ON menu.first = recipe.id OR menu.second = recipe.id OR menu.third = recipe.id WHERE menu.user_id = ? GROUP BY recipe_id ORDER BY menu_id,type_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //こんだて一覧
    public function menuAll($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image ,GROUP_CONCAT(mate_name SEPARATOR '　' ) ,recipe.type_id,menu.menu_id,menu.first,menu.second,menu.third FROM recipe JOIN mate ON mate.recipe_id = recipe.id JOIN menu ON menu.first = recipe.id OR menu.second = recipe.id OR menu.third = recipe.id WHERE menu.user_id = ? GROUP BY recipe_id ORDER BY menu_id,type_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //こんだて前ページの情報
    public function beforeRecipe1($post){
      $sql = "SELECT recipe.id,recipe.title FROM recipe WHERE recipe.id=?";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetch();
      return $result;
    }
    //テキストだけ検索
    public function searchRecipe($post){
      $text = str_replace("　"," ",$post);
      $array = explode(" ",$text);
      $where = "WHERE ";
      $sql1 = "SELECT recipe.id,recipe.title,recipe.image, GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id ";
      for($i = 0;$i < count($array); $i++){
        $where .= " (recipe.title LIKE '%$array[$i]%' OR mate_name LIKE '%$array[$i]%') ";
        if($i < count($array) -1){
          $where .= " AND ";
        }
      }
      $sql2 = "GROUP BY recipe_id";
      $sql = $sql1.$where.$sql2;
      $stmt = $this->connect->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }
    //月齢だけ検索
    public function searchRecipeAge($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image, recipe.type_id,GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id
            WHERE recipe.age_id = ?
            GROUP BY recipe_id";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //全レシピ一覧、検索結果
    public function searchAll($post,$age){
      $text = str_replace("　"," ",$post);
      $array = explode(" ",$text);
      $where = "WHERE ";
      $sql1 = "SELECT recipe.id,recipe.title,recipe.image, GROUP_CONCAT(mate_name SEPARATOR '　' )
            FROM recipe
            JOIN mate ON mate.recipe_id = recipe.id ";
      // 検索欄が空じゃない
      if(!empty($post)){
        for($i = 0;$i < count($array); $i++){
          $where .= " (recipe.title LIKE '%$array[$i]%' OR mate_name LIKE '%$array[$i]%') ";
          if($i < count($array) -1){
            $where .= " AND ";
          }
        }
        //月齢検索が空じゃない
        if(!empty($age)){
          if($age == 1){
            $where .= " AND recipe.age_id = 1";
          }elseif($age == 2){
            $where .= " AND recipe.age_id = 2";
          }elseif($age == 3){
            $where .= " AND recipe.age_id = 3";
          }
          }
      // 検索欄が空
      }else{
        // 月齢検索が空じゃない
        if(!empty($age)){
          if($age == 1){
            $where .= " recipe.age_id = 1";
          }elseif($age == 2){
            $where .= " recipe.age_id = 2";
          }elseif($age == 3){
            $where .= " recipe.age_id = 3";
          }
        }
      }
      $sql2 = " GROUP BY recipe_id";
      $sql = $sql1.$where.$sql2;
      $stmt = $this->connect->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }
    //検索結果、0~6ヶ月
    // public function searchAge($post){
    //   $sql = "SELECT recipe.id,recipe.title,recipe.image, recipe.type_id,GROUP_CONCAT(mate_name SEPARATOR '　' )
    //         FROM recipe
    //         JOIN mate ON mate.recipe_id = recipe.id
    //         WHERE recipe.age_id = ?
    //         GROUP BY recipe_id";
    //   $stmt = $this->connect->prepare($sql);
    //   $param = array($post);
    //   $stmt->execute($param);
    //   $result = $stmt->fetchAll();
    //   return $result;
    // }
    //レシピ詳細
    public function recipeDetail($post){
      $sql = "SELECT recipe.id,recipe.title,recipe.image,type_id,age_id
            FROM recipe
            WHERE recipe.id = ?";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //レシピ詳細、材料
    public function detailMate($post){
      $sql = "SELECT mate_name,num FROM mate WHERE recipe_id=?";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //レシピ詳細、手順
    public function detailProce($post){
      $sql = "SELECT proce_name,sort FROM proce WHERE recipe_id=?";
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);
      $result = $stmt->fetchAll();
      return $result;
    }
    //レシピ削除（管理者）
    public function deleteRecipe($post){
      $sql = 'DELETE FROM recipe WHERE id=?';
      $stmt = $this->connect->prepare($sql);
      $param = array($post);
      $stmt->execute($param);

      $sql1 = 'DELETE FROM proce WHERE recipe_id=?';
        $stmt1 = $this->connect->prepare($sql1);
        $param1 = array($post);
        $stmt1->execute($param1);

      $sql2 = 'DELETE FROM mate WHERE recipe_id=?';
        $stmt2 = $this->connect->prepare($sql2);
        $param2 = array($post);
        $stmt2->execute($param2);
    }
    //バリデート
    public function validate($data){
      $message = array();
      if(empty($data["name"])){
        $message["name"] = "お名前を入力してください";
      }
      if(empty($data["kana"])){
        $message["kana"] = "フリガナを入力してください";
      }
      if(empty($data["mail"])){
        $message["mail"] = "メールアドレスを入力してください";
      }else if(!filter_var($data["mail"],FILTER_VALIDATE_EMAIL)){
        $message["mail"] = "メールアドレスが正しくありません";
      }
      if(empty($data["pass"])){
        $message["pass"] = "パスワードを入力してください";
      }
      return $message;
    }
  }
