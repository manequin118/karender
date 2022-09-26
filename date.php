<?php

include "secure.php";

include 'connect.php';
include 'QueryShcedule.php';
include 'shcedule.php';
require 'vendor/autoload.php';
//曜日を配列に代入
$youbi = array(0 => "日", 1 => "月", 2 => "火", 3 => "水", 4 => "木", 5 => "金", 6 => "土");
// print_r($youbi);



$year = date("Y");
$holidays = \Yasumi\Yasumi::create('Japan', $year, 'ja_JP');

// // $month = $date->format(("m"));
$year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
$month = isset($_GET['month']) ? (int)$_GET['month'] : date("n");
if ($month === 13) {
    $year++;
    $month = 1;
}
//2021/0と来たら2020/12と変換
if ($month === 0) {
    $year--;
    $month = 12;
}

$queryShcedule = new QueryShcedule();
$shcedules = $queryShcedule->findAllDate($_SESSION["id"]);
// print_r($shcedules);


foreach ($shcedules as $shcedule) {
    $results[$shcedule->getId()][$shcedule->getIs_done()] = array($shcedule->getStudyDay() => $shcedule->getTitle());
}


//チェックボックス付きの予定をカレンダーに表示する
function shceduleDisplay($results, $date)
{
    foreach ($results as $id => $doneshceduleArray) {

        foreach ($doneshceduleArray as $done => $shceduleArray) {

            foreach ($shceduleArray as $study_day => $title) {

                if ($study_day == $date && $done == 0) {
                    // echo '<p >
                    // <input name="schedule' . $id . '" class="schedule"  type="checkbox" value="' . $id . '"  >
                    // <a href="show.php?id=' . $id . '">' . $title . "</a>
                    // </p> ";
                    echo '<p >
                    <input name="schedule' . $id . '" class="schedule"  type="checkbox" value="' . $id . '"  >
                    <span">' . $title . "</span>
                    </p> ";
                } elseif ($study_day == $date && $done == 1) {
                    // echo '<p class="shcedule-end" >
                    // <input name="schedule' . $id . '" class="schedule"  type="checkbox" checked value="' . $id . '"  >
                    // <a href="show.php?id=' . $id . '">' . $title . "</a>
                    // </p> ";
                    echo '<p class="shcedule-end" >
                    <input name="schedule' . $id . '" class="schedule"  type="checkbox" checked value="' . $id . '"  >
                    <span">' . $title . "</span>
                    </p> ";
                }
            }
        }
    }
}

function weekJudge($day, $year, $month)
{
    $y = date("w", mktime(0, 0, 0, $month, $day, $year));
    $youbi = array(0 => "日", 1 => "月", 2 => "火", 3 => "水", 4 => "木", 5 => "金", 6 => "土");
    return $youbi[$y];
};




?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>学習カレンダー</title>
    <script></script>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet" />
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
    <?php include "header.php"; ?>
    <?php
    // for ($n = 0; $n < 12; $n++) {
    //1月からの月間の日数をループで取得
    $endMonthDay = date('d', mktime(0, 0, 0, $month + 1, 0, $year));
    $y = date("w", mktime(0, 0, 0, $month, 1, $year));
    ?>
    <div class="arrow">
        <a href="date.php?month=<?php echo $month - 1; ?>&year=<?php echo $year; ?>">&lt;&lt;前月</a>
        <h1>
            <?PHP echo $year; ?>年<?php echo $month; ?>月<br class="is-sp">カレンダー
        </h1>
        <a class="right" href="date.php?month=<?php echo  $month + 1; ?>&year=<?php echo $year; ?>">次月&gt;&gt;</a>
    </div>
    <div class="currentMonth">
        <table>
            <tr class="youbi">
                <?php
                for ($e = 0; $e < 7; $e++) {
                    //2022-1-1からの曜日を取得
                    // $youbi = date('D', mktime(0, 0, 0, $n + 1, $e, date("Y"))); 
                ?>
                    <?php if ($e == 6) { ?>
                        <th class="today"><?php echo $youbi[$e]; ?></th>
                    <?php } elseif ($e == 0) { ?>
                        <th class="red"><?php echo $youbi[$e]; ?></th>
                    <?php } else {  ?>
                        <th><?php echo $youbi[$e]; ?></th>
                    <?php } ?>
                <?php } ?>
            </tr>
            <tr>
                <!-- 空白のセルを曜日番号の数入れる -->
                <?php for ($m = 0; $m < $y; $m++) { ?>
                    <td class="is-pc">&nbsp;</td>
                <?php } ?>
                <!-- 空白のセル最大6から引いた数のみ日にちを表示して祝日はredにする -->
                <?php for ($q = 1; $q <= (7 - $y); $q++) {
                    $holidays = \Yasumi\Yasumi::create('Japan', $year, 'ja_JP');
                    $date1 = $year . "-" . "0" . $month . "-" . str_pad($q, "2", "0", STR_PAD_LEFT);
                ?>
                    <?php if ($year == date("Y") && $month == date("m") && $q == date("d")) : ?>
                        <td class="today">
                            <a href="oneday.php?study_day=<?php echo $year . "-" . $month . "-" . $q; ?>"> <?php echo $q; ?>
                                <span class="is-sp weekend"><?php echo weekJudge($q, $year, $month); ?></span>
                                <?php shceduleDisplay($results, $date1); ?>
                            </a>
                        </td>
                    <?php elseif ($holidays->isHoliday(new DateTime($year . "-" . $month . "-" . $q))) :  ?>
                        <td class="red">
                            <a href="oneday.php?study_day=<?php echo $year . "-" . $month . "-" . $q; ?>">
                                <?php echo $q; ?>
                                <span class="is-sp weekend"><?php echo weekJudge($q, $year, $month); ?></span>
                                <?php shceduleDisplay($results, $date1); ?>
                            </a>
                        </td>
                    <?php else : ?>
                        <td><a href=" oneday.php?study_day=<?php echo $year . "-" . $month . "-" . $q; ?>"><?php echo $q; ?>
                                <span class="is-sp weekend"><?php echo weekJudge($q, $year, $month); ?></span>
                                <?php shceduleDisplay($results, $date1); ?>
                            </a>
                        </td>
                    <?php endif; ?>
                <?php } ?>
            </tr>
            <tr>
                <?php
                //各月の月間日数分ループで回す
                for ($i = (7 - $y); $i < $endMonthDay; $i++) {
                    $w = date("w", mktime(0, 0, 0, $month, $i, $year));
                    // Yasumiライブラリを使って配列で今年の日本の祝日を取得
                    $holidays = \Yasumi\Yasumi::create('Japan', $year, 'ja_JP');
                    $date2 = $year . "-" . "0" . $month . "-" . str_pad(($i + 1), "2", "0", STR_PAD_LEFT);
                    //条件分岐で本日のセルのみ色を変える
                    if ($year == date("Y") && $month == date("m") && $i + 1 == date("d")) : ?>
                        <td class="today"> <a href=" oneday.php?study_day=<?php echo $year . "-" . $month . "-" . $i + 1; ?>"><?php echo $i + 1; ?>
                                <span class="is-sp weekend"><?php echo weekJudge($i + 1, $year, $month); ?></span>
                                <?php shceduleDisplay($results, $date2); ?>
                            </a>
                        </td>
                        <!-- isHoliday関数で祝日がどうか判断する -->
                    <?php
                    elseif ($holidays->isHoliday(new DateTime($year . "-" . $month . "-" . ($i + 1)))) : ?>
                        <td class="red"> <a href=" oneday.php?study_day=<?php echo $year . "-" . $month . "-" . $i + 1; ?>"><?php echo $i + 1; ?>
                                <span class="is-sp weekend"><?php echo weekJudge($i + 1, $year, $month); ?></span>
                                <?php shceduleDisplay($results, $date2); ?>
                            </a>
                        </td>
                    <?php else : ?>
                        <td><a href="oneday.php?study_day=<?php echo $year . "-" . $month . "-" . $i + 1; ?>"> <?php echo $i + 1; ?>
                                <span class="is-sp weekend"><?php echo weekJudge($i + 1, $year, $month); ?></span>
                                <?php shceduleDisplay($results, $date2); ?>
                            </a>
                        </td>
                    <?php endif; ?>
                    <!-- カレンダーっぽくするために1周間ごとに改行を入れる -->
                    <?php if ($w == 5) { ?>
                    <?php echo "</tr>";
                    } ?>
                <?php   } ?>
            </tr>
        </table>
    </div>
    <script src="./node_modules/jquery/dist/jquery.js"></script>
    <script src="check.js"></script>
</body>
<script>
    //スマホカレンダー土日にカラー入れる
    const weekend = document.getElementsByClassName("weekend");
    // console.log(weekend);
    for (let e = 0; e < weekend.length; e++) {
        if (weekend[e].innerHTML == "日") {
            weekend[e].style.color = "rgb(239 12 12)";
        } else if (weekend[e].innerHTML == "土") {
            weekend[e].style.color = "rgb(6 66 236)";
        }
    }
</script>

</html>