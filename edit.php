<?php
include 'connect.php';
include "queryShcedule.php";
include "shcedule.php";

$id = "";
$title = "";        // タイトル
$body = "";         // 本文
$study_day = "";         //日付
$title_alert = "";  // タイトルのエラー文言
$body_alert = "";   // 本文のエラー文言


if (isset($_GET['id'])) {
  $queryShcedule = new QueryShcedule();
  $shcedule = $queryShcedule->find($_GET['id']);


  if ($shcedule) {
    // 編集する記事データが存在したとき、フォームに埋め込む
    $id = $shcedule->getId();
    $title = $shcedule->getTitle();
    $body = $shcedule->getBody();
    $study_day = $shcedule->getStudyDay();
  } else {
    // 編集する記事データが存在しないとき
    header('Location: index.php');
    exit;
  }
} else if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['study_day'])) {
  // id, titleとbodyがPOSTメソッドで送信されたとき
  $title = $_POST["title"];
  $body = $_POST["body"];
  $study_day = $_POST["study_day"];

  $queryShcedule = new QueryShcedule();
  $shcedule = $queryShcedule->find($_POST['id']);

  if ($shcedule) {
    $shcedule->setTitle($title);
    $shcedule->setBody($body);
    $shcedule->setStudyDay($study_day);
    $shcedule->save();
  }
  header('Location: index.php');
  exit;
} else if (!empty($_POST)) {
  // POSTメソッドで送信されたが、titleかbodyが足りないとき
  if (!empty($_POST['id'])) {
    $id = $_POST['id'];
  } else {
    // 編集する記事IDがセットされていなければ、backend.phpへ戻る
    header('Location: index.php');
    exit;
  }

  // 存在するほうは変数へ、ない場合空文字にしてフォームのvalueに設定する
  if (!empty($_POST['title'])) {
    $title = $_POST['title'];
  } else {
    $title_alert = "タイトルを入力してください。";
  }

  if (!empty($_POST['body'])) {
    $body = $_POST['body'];
  } else {
    $body_alert = "本文を入力してください。";
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
  <div class="post-container">
    <div class="post-contents">
      <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <label for="">タイトル</label>
        <?php echo !empty($title_alert) ?  $title_alert  : '' ?>
        <input type="text" name="title" value="<?php echo $title; ?>">
        <label for="">内容</label>
        <?php echo !empty($body_alert) ?  $body_alert : '' ?>
        <input type="text" name="body" value="<?php echo $body; ?>">
        <label for="">日程</label>
        <input type="date" name="study_day">
        <button type="submit">送信する</button>
      </form>
    </div>
    <a href="date.php">カレンダーへ</a>
  </div>

</body>

</html>