<?php
class QueryUsers extends connect
{
  private $user;

  public function __construct()
  {
    parent::__construct();
  }

  public function setUser(Users $user)
  {
    $this->user = $user;
  }

  public function save()
  {
    $name = $this->user->getName();
    $password = $this->user->getPassword();
    $stmt = $this->dbh->prepare("INSERT INTO users (name,password,created_at,updated_at)
    VALUES (:name,:password,NOW(),NOW())");
    $stmt->bindParam(":name", $name, PDO::PARAM_STR);
    $stmt->bindParam(":passord", $password, PDO::PARAM_STR);
    $stmt->execute();
  }

  public function find()
  {
  }
}
