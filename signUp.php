<?php
include 'connect.php';
include "user.php";
include "queryUsers.php";

$name = "";
$password = "";
$err = array();
if (!empty($_POST["name"]) && !empty($_POST["password"])) {
  $name = $_POST["name"];
  $password = $_POST["password"];



  $db = new connect();
  $sql = "INSERT INTO users (name,password) VALUES (:name,:password)";
  $result = $db->query($sql, array(":name" => $name, ":password" => password_hash($password, PASSWORD_DEFAULT)));


  header("Location: login.php");

  // $user = new Users();
  // $user->setName($name);
  // $user->setPassword($password);
  // $user->save();
  // header("Location: login.php");
} else {
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
    <form method="post" action="signUp.php">
      <h1 class="loginHeader">新規ユーザー登録
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
      <button class="w-100 btn btn-lg btn-primary" type="submit">新規登録</button>

    </form>
    <script src="check.js"></script>
</body>

</html>