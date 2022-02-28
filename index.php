<?php
include 'connect.php';
include 'queryShcedule.php';
include 'shcedule.php';

$queryShcedule = new QueryShcedule();
$shcedules = $queryShcedule->findAll();


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
  <div class="shcedule-container">
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
          <?php foreach ($shcedules as $shcedule) : ?>
            <tr>
              <td><?php echo $shcedule->getId() ?></td>
              <td><?php echo $shcedule->getTitle() ?></td>
              <td><?php echo $shcedule->getBody() ?></td>
              <td><?php echo $shcedule->getStudyDay() ?></td>
              <td><a href="edit.php?id=<?php echo $shcedule->getId() ?>" class="btn btn-success">編集</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else : ?>
      <div class="alert alert-info">
        <p>記事はありません。</p>
      </div>
    <?php endif; ?>
  </div>
</body>

</html>