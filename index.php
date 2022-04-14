<?php
include 'connect.php';
include "secure.php";
include 'queryShcedule.php';
include 'shcedule.php';
include 'queryUsers.php';

$queryShcedule = new QueryShcedule();
$shcedules = $queryShcedule->findAll();
// var_dump($shcedules);

$queryUser = new QueryUsers();
$users = $queryUser->find();

$id = $_SESSION["id"];


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
  <div class="shcedule-container">
    <h2><?php  ?></h2>
    <?php if ($shcedules) : ?>
      <table class="table ">
        <thead>
          <tr>
            <th>ID</th>
            <th>タイトル</th>
            <th>本文</th>
            <th>日程</th>
            <th>ボタン</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($shcedules as $shcedule) :
          ?>
            <tr>
              <!-- show.phpのデータの取り方を参考にしたほうがいいかも ↓if文がいるのか -->
              <?php if ($shcedule->getUser_id() == $id) : ?>
                <td><?php echo $shcedule->getId() ?></td>
                <td><?php echo $shcedule->getTitle() ?></td>
                <td><?php echo $shcedule->getBody() ?></td>
                <td><?php echo $shcedule->getStudyDay() ?></td>
                <td><a href="edit.php?id=<?php echo $shcedule->getId() ?>" class="">編集</a>
                </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert alert-info">
        <p>記事はありません。</p>
      </div>
    <?php endif; ?>
    <div class="Gw6Zhc"><a href="post.php"><svg width="100" height="100s" viewBox="0 0 36 36">
          <path fill="#34A853" d="M16 16v14h4V20z"></path>
          <path fill="#4285F4" d="M30 16H20l-4 4h14z"></path>
          <path fill="#FBBC05" d="M6 16v4h10l4-4z"></path>
          <path fill="#EA4335" d="M20 16V6h-4v14z"></path>
          <path fill="none" d="M0 0h36v36H0z"></path>
        </svg></a></div>
  </div>
  <script src="check.js"></script>
</body>

</html>