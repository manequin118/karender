<?php

use Yasumi\Yasumi;

$lastDate = date('t', strtotime('last month'));
$nextDate = date('t', strtotime('next month'));

$date = new DateTime("2022-1-1");
$dateFormat = $date->format("Y/m");
$tt = $date->format("t");

//曜日を配列に代入
$youbi = array(0 => "日", 1 => "月", 2 => "火", 3 => "水", 4 => "木", 5 => "金", 6 => "土");
// print_r($youbi);

require 'vendor/autoload.php';

$holidays = \Yasumi\Yasumi::create('Japan', 2022, 'ja_JP');
print_r($holidays->getHolidayDates([2022 - 01 - 01]));
foreach ($holidays as $holiday) {
    echo $holiday  . "<br>";
    // var_dump($holiday);
}

$day = new DateTime(date("Y") . "-" . (1) . "-" . (1));
print_r($day);

//翌月の情報を取る
// $plusMonth = $date->modify('+1 months');
// $plusMonthvalue = substr($plusMonth->format("m"), 1, 1);
// var_dump($plusMonthvalue);
// $plusMonthtt = $plusMonth->format("t");
// $date = $date->modify('+1 day');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./style.css">
</head>

<body>
    <h1>2022年カレンダー</h1>
    <?php
    for ($n = 0; $n < 12; $n++) {
        //1月からの月間の日数をループで取得
        $endMonthDay = date('d', mktime(0, 0, 0, date('m') + $n, 0, date('Y')));
        $y = date("w", mktime(0, 0, 0, $n + 1, 1, date("Y")));

    ?>
    <div class="currentMonth">
        <p><?php echo $n + 1; ?>月</p>
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

                <?php for ($q = 1; $q <= (7 - $y); $q++) { ?>
                <td><?php echo $q; ?></td>
                <?php } ?>
            </tr>
            <tr>
                <?php
                    //各月の月間日数分ループで回す
                    for ($i = (7 - $y); $i < $endMonthDay; $i++) {
                        //曜日を数値で取得する
                        $w = date("w", mktime(0, 0, 0, $n + 1, $i, date("Y")));


                        // Yasumiライブラリを使って配列で今年の日本の祝日を取得
                        $holidays = \Yasumi\Yasumi::create('Japan', date("Y"), 'ja_JP');



                        //条件分岐で本日のセルのみ色を変える
                        if ($n + 1 == date("m") && $i + 1 == date("d")) : ?>
                <td class="today"> <?php echo $i + 1; ?></td>
                <!-- isHoliday関数で祝日がどうか判断する -->
                <?php elseif ($holidays->isHoliday(new DateTime(date("Y") . "-" . ($n + 1) . "-" . ($i + 1)))) : ?>
                <td class="red"> <?php echo $i + 1; ?></td>
                <?php else : ?>
                <td> <?php echo $i + 1; ?></td>
                <?php endif; ?>
                <!-- カレンダーっぽくするために1周間ごとに改行を入れる -->
                <?php if ($w == 5) { ?>
                <?php echo "</tr>";
                        } ?>

                <?php   } ?>
            </tr>
        </table>
    </div>
    <?php } ?>
</body>

</html>