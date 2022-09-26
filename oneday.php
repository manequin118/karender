<?php
include 'connect.php';
include "secure.php";
include "QueryShcedule.php";
include "shcedule.php";

if (isset($_GET['study_day'])) {
  $study_day = $_GET["study_day"];
  $user_id = $_SESSION["id"];

  // 指定日の予定のみ表示する
  $queryShcedule = new QueryShcedule();
  $schedules = $queryShcedule->scheduleOneDay($study_day, $user_id);


  // $study_dayから文字列を切り出して日付にする
  $dateSplit = explode("-", $study_day);
  $month = $dateSplit[1];
  $day = $dateSplit[2];
}

//簡単にデバックする関数 エラー文表示
ini_set('display_errors', "On");

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
  <div class="day-container">
    <h2><?php echo  $month; ?>月<?php echo $day; ?>日の予定一覧</h2>
    <?php if (count($schedules) > 0) :
    ?>
      <?php foreach ($schedules as $schedule) : ?>
        <?php if ($schedule->getIs_done() == 0) : ?>
          <div class="day-card">
            <p>
              <a href="show.php?id= <?php echo $schedule->getId(); ?>"> <?php echo $schedule->getTitle(); ?></a>
              <input type="checkbox" class="schedule" value="<?php echo $schedule->getId(); ?>">
            </p>
          </div>
        <?php elseif ($schedule->getIs_done() == 1) : ?>
          <div class="day-card">
            <p class="shcedule-end">
              <a href="show.php?id= <?php echo $schedule->getId(); ?>"> <?php echo $schedule->getTitle(); ?></a>
              <input type="checkbox" checked class="schedule" value="<?php echo $schedule->getId(); ?>">
            </p>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php else :
    ?>
      <div class="not-schedule">
        <div>
          <img src="./img/ojigi.png" alt="">
        </div>
        <p>予定はまだ登録されてません。</p>
      </div>
    <?php endif;
    ?>
  </div>
  <script src="./node_modules/jquery/dist/jquery.js"></script>
  <script src="check.js"></script>
</body>

</html>