<?php
include "secure.php";
include 'connect.php';
include "shcedule.php";
include "QueryShcedule.php";

$id = "";
$title = "";        // タイトル
$body = "";         // 本文
$study_day = "";    //日付
$title_alert = "";  // タイトルのエラー文言
$body_alert = "";   // 本文のエラー文言


if (!empty($_POST['title']) && !empty($_POST['body']) && !empty($_POST['study_day'])) {
  // id, titleとbodyがPOSTメソッドで送信されたとき
  $title = $_POST["title"];
  $body = $_POST["body"];
  $study_day = $_POST["study_day"];
  $user_id = $_SESSION["id"];


  // $db = new connect();
  // $sql = "INSERT INTO shcedule (title,body,study_day,user_id,created_at, updated_at)
  // VALUES (:title,:body,:study_day,:user_id, NOW(), NOW())";

  // $result = $db->query($sql, array(':title' => $title, ':body' => $body, ":study_day" => $study_day, ":user_id" => $user_id));


  // header('Location: index.php');

  $shcedule = new Shcedule();
  $shcedule->setTitle($title);
  $shcedule->setBody($body);
  $shcedule->setStudyDay($study_day);
  $shcedule->setUser_id($user_id);
  $shcedule->save();
  header('Location: date.php');
} else if (!empty($_POST)) {
  // POSTメソッドで送信されたが、titleかbodyが足りないとき
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
  if (!empty($_POST['study_day'])) {
    $study_day = $_POST['study_day'];
  } else {
    $study_day_alert = "日付けを指定してください。";
  }
}
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
  <div class="post-container">
    <div class="post-contents">
      <form action="post.php" method="post">
        <label for="">タイトル</label>
        <p class="alert"><?php echo !empty($title_alert) ?  $title_alert  : '' ?></p>
        <input type="text" name="title" value="<?php echo $title; ?>">
        <label for="">内容</label>
        <p class="alert"><?php echo !empty($body_alert) ?  $body_alert : '' ?></p>
        <input type="text" name="body" value="<?php echo $body; ?>">
        <label for="">日程</label>
        <p class="alert"><?php echo !empty($study_day_alert) ?  $study_day_alert : '' ?></p>
        <input type="date" name="study_day">
        <button type="submit">送信する</button>
      </form>
    </div>

    <a href="date.php">カレンダーへ</a>
    <a href="index.php">一覧へ</a>
  </div>
  <script src="check.js"></script>
</body>

</html>