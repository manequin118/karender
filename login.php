<?php

include "connect.php";
// include "secure.php";

$err = null;

if (isset($_POST['name']) && isset($_POST['password'])) {
  $db = new connect();
  // $name = $_POST["name"];
  // $password = $_POST["password"];

  // 実行したいSQL
  $select = "SELECT * FROM users WHERE name=:name ";

  // 第2引数でどのパラメータにどの変数を割り当てるか決める
  $stmt = $db->query($select, array(':name' => $_POST["name"]));



  // レコード1件を連想配列として取得する
  $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // var_dump($result);
  // var_dump($_POST["password"]);
  // var_dump(password_hash($_POST["password"], PASSWORD_DEFAULT));
  // var_dump(password_verify($_POST["password"], password_hash($_POST["password"], PASSWORD_DEFAULT)));
  // exit;


  foreach ($results as $result) {
    if ($result && password_verify($_POST["password"], $result['password'])) {
      // 結果が存在し、パスワードも正しい場合
      session_start();
      session_regenerate_id(true);
      $_SESSION['id'] = $result['id'];

      header('Location: index.php');
    } else {
      $err = "ログインできませんでした。";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" type="text/css" href="./style.css">

</head>

<body>
  <?php include "header.php"; ?>
  <main class="form-signin">
    <form method="post" action="login.php">
      <h1 class="loginHeader">ユーザーログイン
      </h1>
      <?php
      if (!is_null($err)) {
        echo '<div class="alert alert-danger">' . $err . '</div>';
      }
      ?>
      <label class="visually-hidden">ユーザ名</label>
      <input type="text" name="name" class="form-control" placeholder="ユーザ名" required autofocus>
      <label class="visually-hidden">パスワード</label>
      <input type="password" name="password" class="form-control" placeholder="パスワード" required>
      <button class="w-100 btn btn-lg btn-primary" type="submit">ログイン</button>

    </form>
    <script src="check.js"></script>
</body>

</html>