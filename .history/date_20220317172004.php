<?php

use Yasumi\Yasumi;

include 'connect.php';
include 'queryShcedule.php';
include 'shcedule.php';
//曜日を配列に代入
$youbi = array(0 => "日", 1 => "月", 2 => "火", 3 => "水", 4 => "木", 5 => "金", 6 => "土");
// print_r($youbi);

require 'vendor/autoload.php';

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
$shcedules = $queryShcedule->findAll();
$results = array();
foreach ($shcedules as $shcedule) {

    $results[$shcedule->getStudyDay()][] =  $shcedule->getTitle();
}

// print_r($results);

foreach ($results as $result => $values) {
    var_dump($values);
    foreach ($values as $value) {

        // var_dump($value);
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
    <script></script>
    <link href="https://unpkg.com/sanitize.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/Modaal/0.4.4/css/modaal.min.css">
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
    <div class="modal-container" id="modalMain">
        <div class="modal-contents">
            <form action="post.php" method="post">
                <label for="">タイトル</label>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>">
                <label for="">内容</label>
                <input type="text" name="body" id="body" value="<?php echo $body; ?>">
                <label for="">日程</label>
                <input type="date" name="study_day" id="study_day">
                <button type="submit">送信する</button>
                <div class="batu" id="modalClose"></div>
            </form>
        </div>
    </div>
    <h1>
        <?PHP echo $year; ?>年カレンダー
    </h1>
    <?php
    // for ($n = 0; $n < 12; $n++) {
    //1月からの月間の日数をループで取得
    $endMonthDay = date('d', mktime(0, 0, 0, $month + 1, 0, $year));
    $y = date("w", mktime(0, 0, 0, $month, 1, $year));
    ?>
    <div class="currentMonth">
        <p><?php echo ltrim($month, 0);  ?>月</p>
        <table>
            <tr>
                <?php
                for ($e = 0; $e < 7; $e++) {
                    //2022-1-1からの曜日を取得
                    // $youbi = date('D', mktime(0, 0, 0, $n + 1, $e, date("Y"))); 
                ?>
                <th><?php echo $youbi[$e]; ?></th>
                <?php }  ?>
            </tr>
            <tr>
                <!-- 空白のセルを曜日番号の数入れる -->
                <?php for ($m = 0; $m < $y; $m++) { ?>
                <td>&nbsp;</td>
                <?php } ?>
                <!-- 空白のセル最大6から引いた数のみ日にちを表示して祝日はredにする -->
                <?php for ($q = 1; $q <= (7 - $y); $q++) {
                    $holidays = \Yasumi\Yasumi::create('Japan', $year, 'ja_JP');
                    $date1 = $year . "-" . "0" . $month . "-" . str_pad($q, "2", "0", STR_PAD_LEFT);
                ?>
                <?php if ($year == date("Y") && $month == date("m") && $q == date("d")) : ?>
                <td class="today"> <?php echo $q; ?></td>
                <?php elseif ($holidays->isHoliday(new DateTime($year . "-" . $month . "-" . $q))) :  ?>
                <td class="red"><?php echo $q; ?></td>
                <?php else : ?>
                <td> <?php echo $q; ?>
                    <?php foreach ($results as $result => $r) {
                                if ($result == $date1) {
                                    foreach ($r as $value) {
                                        echo '<p><input type="checkbox" >' . $value . "</p>";
                                    }
                                }
                            } ?>
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
                <td class="today"> <?php echo $i + 1; ?></td>
                <!-- isHoliday関数で祝日がどうか判断する -->
                <?php
                    elseif ($holidays->isHoliday(new DateTime($year . "-" . $month . "-" . ($i + 1)))) : ?>
                <td class="red"> <?php echo $i + 1; ?>
                    <?php foreach ($results as $result => $r) {
                                if ($result == $date2) {
                                    foreach ($r as $value) {
                                        echo '<p><input  type="checkbox" >' . $value . "</p>";
                                    }
                                }
                            } ?>
                </td>

                <?php else : ?>
                <td> <?php echo $i + 1; ?>
                    <?php foreach ($results as $result => $r) {
                                if ($result == $date2) {
                                    foreach ($r as $value) {
                                        echo '<p><input  type="checkbox" >' . $value . "</p> ";
                                    }
                                }
                            } ?></td>
                <?php endif; ?>
                <!-- カレンダーっぽくするために1周間ごとに改行を入れる -->
                <?php if ($w == 5) { ?>
                <?php echo "</tr>";
                    } ?>
                <?php   } ?>
            </tr>
        </table>
    </div>
    <!-- 予定を登録するモーダル表示のアイコン -->
    <div class="Gw6Zhc" id="modalOpen"><svg width="100" height="100s" viewBox="0 0 36 36">
            <path fill="#34A853" d="M16 16v14h4V20z"></path>
            <path fill="#4285F4" d="M30 16H20l-4 4h14z"></path>
            <path fill="#FBBC05" d="M6 16v4h10l4-4z"></path>
            <path fill="#EA4335" d="M20 16V6h-4v14z"></path>
            <path fill="none" d="M0 0h36v36H0z"></path>
        </svg></div>

    <div class="arrow">
        <a href="date.php?month=<?php echo $month - 1; ?>&year=<?php echo $year; ?>">&lt;&lt;戻る</a>
        <a href="date.php?month=<?php echo  $month + 1; ?>&year=<?php echo $year; ?>">次へ&gt;&gt;</a>
    </div>
    <script src="modal.js"></script>
</body>

</html>