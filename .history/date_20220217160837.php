<?php

$lastDate = date('t', strtotime('last month'));
$nextDate = date('t', strtotime('next month'));

$date = new DateTime("2022-1-1");
$dateFormat = $date->format("Y/m");
$tt = $date->format("t");

//曜日を配列に代入
$youbi = array(1 => "日", 2 => "月", 3 => "火", 4 => "水", 5 => "木", 6 => "金", 7 => "土");
// print_r($youbi);


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

    <?php
    for ($n = 0; $n < 12; $n++) {
        //1月からの月間の日数をループで取得
        $endMonthDay = date('d', mktime(0, 0, 0, date('m') + $n, 0, date('Y')));
        $y = date("w", mktime(0, 0, 0, date('m') + $n, 0, date("Y")));
        print_r($y);
    ?>
    <div class="currentMonth">
        <p><?php echo $n + 1; ?>月</p>
        <table>
            <tr>
                <?php
                    for ($e = 1; $e <= 7; $e++) {
                        //2022-1-1からの曜日を取得
                        // $youbi = date('D', mktime(0, 0, 0, $n + 1, $e, date("Y"))); 
                    ?>
                <th><?php echo $youbi[$e]; ?></th>
                <?php }  ?>
            </tr>
            <tr>
                <?php
                    //各月の月間日数分ループで回す
                    for ($i = 0; $i < $endMonthDay; $i++) {

                        //  for ($y=0; )
                        //条件分岐で本日のセルのみ色を変える
                        // if ($n + 1 == date("m") && $i == date("d")) :
                    ?>

                <?php if ($i == $y) : ?>
                <?php for ($m = 0; $m < $y; $m++) { ?>
                <td>&nbsp;</td>
                <?php } ?>
                <?php endif; ?>
                <td> <?php echo $i + 1; ?></td>

                <?php
                        //カレンダーっぽくするために1周間ごとに改行を入れる
                        if (($i + 1) % 7 == 0) { ?>
                <?php
                            echo "</tr>";
                        }
                    }
                    ?>
            </tr>
        </table>
    </div>
    <?php } ?>
</body>

</html>