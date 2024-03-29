<?php
include 'connect.php';
include "secure.php";
include 'QueryShcedule.php';
include 'shcedule.php';
include 'queryUsers.php';

$queryShcedule = new QueryShcedule();
$shcedules = $queryShcedule->findAll();
// var_dump($shcedules);

$queryUser = new QueryUsers();
$users = $queryUser->find();

$id = $_SESSION["id"];

$month = substr(date("m"), 1);


?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>学習カレンダー</title>
  <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
  <?php include "header.php"; ?>
  <div class="shcedule-container">
    <h2><?php echo  $month; ?>月の予定一覧</h2>
    <?php if ($shcedules) : ?>
      <table class="table">
        <thead class="is-pc">
          <tr>
            <th>状態</th>
            <th>タイトル</th>
            <th>本文</th>
            <th>日程</th>
            <th>ボタン</th>
          </tr>
        </thead>
        <tbody class="is-pc">
          <?php foreach ($shcedules as $shcedule) :
          ?>
            <tr>
              <!-- show.phpのデータの取り方を参考にしたほうがいいかも ↓if文がいるのか -->
              <?php if ($shcedule->getUser_id() == $id) : ?>
                <?php if ($shcedule->getIs_done() == 1) : ?>
                  <td>完了！</td>
                <?php else : ?>
                  <td>未完了</td>
                <?php endif; ?>
                <td><?php echo $shcedule->getTitle() ?></td>
                <td><?php echo $shcedule->getBody() ?></td>
                <td><?php echo $shcedule->getStudyDay() ?></td>
                <td>
                  <a class="edit" href="edit.php?id=<?php echo $shcedule->getId() ?>" class="">編集</a>
                  <a class="delete" onclick="return confirm('本当に削除してよろしいですか?')" href="delete.php?id=<?php echo $shcedule->getId() ?>" class="">削除</a>
                </td>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        <thead class="is-sp sphead">
          <tr>
            <th>タイトル、内容</th>
            <th>日付</th>
          </tr>
        </thead>
        <tbody class="is-sp list">
          <?php foreach ($shcedules as $shcedule) :
          ?>
            <tr>
              <td><span><?php echo $shcedule->getTitle() ?></span>
                <span><?php echo $shcedule->getBody() ?></span>
              </td>
              <td><?php echo $shcedule->getStudyDay() ?>
                <span>
                  <a class="edit" href="edit.php?id=<?php echo $shcedule->getId() ?>" class="">編集</a>
                </span>
                <span>
                  <a class="delete" onclick="return confirm('本当に削除してよろしいですか?')" href="delete.php?id=<?php echo $shcedule->getId() ?>" class="">削除</a>
                </span>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert alert-info">
        <p>記事はありません。</p>
      </div>
    <?php endif; ?>

    <script src="check.js"></script>
</body>

</html>