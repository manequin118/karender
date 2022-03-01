<?php
include 'connect.php';
include "shcedule.php";
include "QueryShcedule.php";

$id = "";
$title = "";        // タイトル
$body = "";         // 本文
$study_day = "";         //日付
$title_alert = "";  // タイトルのエラー文言
$body_alert = "";   // 本文のエラー文言
$study_day = "";     //日にちのエラー文

if (!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['study_day'])) {
  // id, titleとbodyがPOSTメソッドで送信されたとき
  $title = filter_input(INPUT_POST, "title");
  $body = filter_input(INPUT_POST, "body");
  $study_day = filter_input(INPUT_POST, "study_day");

  $shcedule = new Shcedule();
  $shcedule->setTitle($title);
  $shcedule->setBody($body);
  $shcedule->setStudyDay($study_day);
  $shcedule->save();
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
                <label for="">タイトル</label>
                <input type="text" name="title">
                <label for="">内容</label>
                <input type="text" name="body">
                <label for="">日程</label>
                <input type="date" name="study_day">
                <button type="submit">送信する</button>
            </form>
        </div>
        <a href="date.php">カレンダーへ</a>
    </div>

</body>

</html>