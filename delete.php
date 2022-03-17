<?php
include 'connect.php';
include 'queryShcedule.php';
include 'shcedule.php';

if (!empty($_GET['id'])) {
  $queryShcedule = new QueryShcedule();
  $shcedule = $queryShcedule->find($_GET['id']);
  if ($shcedule) {
    $shcedule->delete();
  }
}
header("Location: index.php");
