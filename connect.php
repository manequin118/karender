<?php
include 'config.php';

class connect
{

  const DB_NAME = "carender";
  const HOST = "localhost";
  const USER = "root"; //root myuser
  const PASS = "secret"; //secret Sakana118@

  //メンバ変数
  public $dbh;

  //mysqlに接続
  public function __construct()
  {
    //DSNを設定
    $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";
    try {
      // PDOのインスタンスをクラス変数に格納する
      $this->dbh = new PDO($dsn, self::USER, self::PASS);
    } catch (Exception $e) {
      // Exceptionが発生したら表示して終了
      exit($e->getMessage());
    }
    // DBのエラーを表示するモードを設定
    $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
  }


  public function query($sql, $param = null)
  {
    // プリペアドステートメントを作成し、SQL文を実行する準備をする
    $stmt = $this->dbh->prepare($sql);
    // パラメータを割り当てて実行し、結果セットを返す
    $stmt->execute($param);
    return $stmt;
  }
}
