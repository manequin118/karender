<?php
class QueryShcedule extends connect
{
  private $shcedule;

  public function __construct()
  {
    parent::__construct();
  }

  public function setShcedule(Shcedule $shcedule)
  {
    $this->shcedule = $shcedule;
  }

  public function save()
  {
    if ($this->shcedule->getId()) {
    } else {
      $title = $this->shcedule->getTitle();
      $body = $this->shcedule->getBody();
      $study_day = $this->shcedule->getStudyDay();
      $stmt = $this->dbh->prepare("INSERT INTO shcedule (title,body,created_at,updated_at,study_day)
      VALUES (:title,:body,NOW(),NOW(),:study_day) ");
      $stmt->bindParam(":title", $title, PDO::PARAM_STR);
      $stmt->bindParam(":body", $body, PDO::PARAM_STR);
      $stmt->bindParam(":study_day", $study_day, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  public function find($id)
  {
    $stmt = $this->dbh->prepare("SELECT * FROM shcedule WHERE id=:id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $shcedule = null;
    if ($result) {
      $shcedule = new Shcedule();
      $shcedule->setId($result['id']);
      $shcedule->setTitle($result['title']);
      $shcedule->setBody($result['body']);
      $shcedule->setStudyDay($result['study_day']);
      $shcedule->setCreatedAt($result['created_at']);
      $shcedule->setUpdatedAt($result['updated_at']);
    }
    return $shcedule;
  }
}
