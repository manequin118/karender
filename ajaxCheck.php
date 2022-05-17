<?php
include "secure.php";
include 'connect.php';
include "shcedule.php";
include "queryShcedule.php";

$ids = array();
$ids = $_POST['checkbox'];

var_dump($ids);

$db = new connect();
foreach ($ids as $id) {
  $sql = "UPDATE shcedule SET is_done=1 WHERE id=:id";
  $result = $db->query($sql, array(":id" => $id));
}
