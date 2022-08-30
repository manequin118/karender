<?php

use PhpParser\Comment;

include "secure.php";
include 'connect.php';
include "shcedule.php";
include "QueryShcedule.php";

if (isset($_POST["comment_body"]) && isset($_POST['id'])) {
  $comment = filter_input(INPUT_POST, "comment_body");
  $id = filter_input(INPUT_POST, "id");

  header("Content-type: application/json; charset=UTF-8");

  // var_dump($user_id);
  $db = new connect();
  $sql = "INSERT INTO memo (memo_body,shcedule_id,created_at, updated_at) 
  VALUE (:memo_body,:shcedule_id,NOW(), NOW())";

  $result = $db->query($sql, array(':memo_body' => $comment, ':shcedule_id' => $id));


  $memo_id = $db->dbh->lastInsertId();
  $responce = array("comment" => $comment, "id" => $id, "memo_id" => $memo_id);


  echo json_encode($responce);
  exit;
}
