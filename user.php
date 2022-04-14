<?php
class Users
{
  private $id;
  private $name;
  private $password;

  public function save()
  {
    $queryUser = new QueryUsers();
    $queryUser->setUser($this);
    $queryUser->save();
  }

  public function getId()
  {
    return $this->id;
  }
  public function getName()
  {
    return $this->name;
  }
  public function getPassword()
  {
    return $this->password;
  }

  public function setId($id)
  {
    $this->id = $id;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function setPassword($password)
  {
    $this->password = $password;
  }
}
