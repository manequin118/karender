<?php
include 'connect.php';
include "QueryShcedule.php";
include "Shcedule.php";

$id = "";
$title = "";        // タイトル
$body = "";         // 本文
$study_day = "";         //日付
$title_alert = "";  // タイトルのエラー文言
$body_alert = "";   // 本文のエラー文言
$study_day = "";     //日にちのエラー文

if (isset($_GET['id'])) {
  $queryShcedule = new QueryShcedule();
  $shcedule = $queryShcedule->find($_GET['id']);

  // if ($shcedule) {
  //   // 編集する記事データが存在したとき、フォームに埋め込む
  //   $id = $shcedule->getId();
  //   $title = $shcedule->getTitle();
  //   $body = $shcedule->getBody();
  //   $study_day = $shcedule->getStudyDay();
  // } else {
  //   // 編集する記事データが存在しないとき
  //   header('Location: post.php');
  //   exit;
  // }
} else if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['study_day'])) {
  // id, titleとbodyがPOSTメソッドで送信されたとき
  $title = filter_input(INPUT_POST, "title");
  $body = filter_input(INPUT_POST, "body");
  $study_day = filter_input(INPUT_POST, "study_day");

  $queryShcedule = new QueryShcedule();
  $shcedule = $queryShcedule->find($_GET['id']);

  if ($shcedule) {
    $shcedule->setTitle($title);
    $shcedule->setBody($body);
    $shcedule->setStudyDay($study_day);
    $shcedule->save();
  }
  // header('Location: post.php');
  // exit;
} else {
  header('Location: post.php');
  exit;
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
            <p><?php echo $title; ?></p>
            <p><?php echo $body; ?></p>
            <p><?php echo $study_day; ?></p>
        </div>
    </div>

</body>

</html>