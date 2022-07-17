<?php
include 'connect.php';
include "queryShcedule.php";
include "shcedule.php";
include "memo.php";

if (isset($_GET['id'])) {
  $shcedule_id = $_GET["id"];

  $queryShcedule = new QueryShcedule();
  $shcedule = $queryShcedule->find($shcedule_id);
  if ($shcedule) {
    $title = $shcedule->getTitle();
    $body = $shcedule->getBody();
    $study_day = $shcedule->getStudyDay();
    $is_done = $shcedule->getIs_done();
  }
  $memos = $queryShcedule->findAllMemo($shcedule_id);
}


// if (isset($_POST["comment_body"])) {
//   $comment = filter_input(INPUT_POST, "comment_body");
//   var_dump($comment);
// }

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

    <input type="text" name="comment" id="comment_body">
    <input type="hidden" name="id" id="shcedule_id" value="<?php echo $shcedule_id; ?>">
    <input type="submit" value="送信" id="comment_button">

    <div id="result">
      <p>メモ内容…</p>
      <ul id="comment">
        <?php foreach ($memos as $memo) : ?>
          <li id="<?php echo $memo->getId(); ?>"><?php echo  $memo->getMemo_body();  ?>
            <input type="submit" value="✖️" id="comment_delete" data-id="<?php echo $memo->getId(); ?>"></input>
            <input type="hidden" data-id="<?php echo $memo->getId(); ?>" id="comment_id"></input>
          </li>

        <?php endforeach; ?>
      </ul>
    </div>

    <!-- <div class="under-body">

      <a href="date.php">カレンダーへ</a>
      <a href="index.php">一覧へ</a>
    </div> -->
  </div>
  <script src="./node_modules/jquery/dist/jquery.js"></script>
  <script src="check.js"></script>

</body>

</html>