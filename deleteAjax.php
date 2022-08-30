<?php
include "secure.php";
include 'connect.php';
include "shcedule.php";
include "QueryShcedule.php";

if (isset($_POST['id'])) {
  $id = filter_input(INPUT_POST, "id");
  header("Content-type: application/json; charset=UTF-8");

  $db = new connect();
  $sql = "DELETE FROM memo WHERE id = :comment_id";
  $result = $db->query($sql, array(':comment_id' => $id));

  $responce = array("comment_id" => $id);

  echo json_encode($responce);
  exit;
}
