<?php

namespace App\Config;
/*
@Envファイルコネクションクラスです。
*/

class config
{
  public static function getEnv($req)
  {
    if ($req == null) return;
    $arr = "";
    $envArr = explode("\n", file_get_contents(__DIR__ . "/.env"));
    $envVal = [];
    foreach ($envArr as $key => $val) {
      $arr = explode('=', trim($val));
      $envVal += [$arr[0] => $arr[1]];
    }
    return $envVal[$req];
  }
}
