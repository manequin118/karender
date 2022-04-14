<?php
include 'connect.php';
include "queryShcedule.php";
include "shcedule.php";
if (isset($_GET['id'])) {

  $queryShcedule = new QueryShcedule();
  $shcedule = $queryShcedule->find($_GET['id']);
  if ($shcedule) {
    $title = $shcedule->getTitle();
    $body = $shcedule->getBody();
    $study_day = $shcedule->getStudyDay();
  }
}

$day = date("Y年" .  "m月" . "d日", strtotime($study_day));

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
  <div class="show-container">
    <div class="date">日程：<?php echo $day; ?></div>
    <div class="title_header">
      学習言語
      <h2><?php echo $title; ?></h2>
    </div>
    <div class="contents-body">
      学習内容
      <p> <?php echo $body; ?></p>
    </div>
    <form action="" method="post">
      <input type="text">
      <input type="hidden" name="comment" id="">
    </form>
    <div id="result">

    </div>

    <div class="under-body">

      <a href="date.php">カレンダーへ</a>
      <a href="index.php">一覧へ</a>
    </div>


  </div>


  <script src="check.js"></script>

</body>

</html>