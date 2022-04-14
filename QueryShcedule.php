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
      $id = $this->shcedule->getId();
      $title = $this->shcedule->getTitle();
      $body = $this->shcedule->getBody();
      $study_day = $this->shcedule->getStudyDay();
      $stmt = $this->dbh->prepare("UPDATE shcedule
                SET title=:title, body=:body,study_day=:study_day, updated_at=NOW() WHERE id=:id");
      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
      $stmt->bindParam(':body', $body, PDO::PARAM_STR);
      $stmt->bindParam(':study_day', $study_day, PDO::PARAM_STR);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
    } else {
      $title = $this->shcedule->getTitle();
      $body = $this->shcedule->getBody();
      $study_day = $this->shcedule->getStudyDay();
      $stmt = $this->dbh->prepare("INSERT INTO shcedule (title,body,study_day,created_at,updated_at)
        VALUES (:title,:body,:study_day,NOW(),NOW())");
      $stmt->bindParam(":title", $title, PDO::PARAM_STR);
      $stmt->bindParam(":body", $body, PDO::PARAM_STR);
      $stmt->bindParam(":study_day", $study_day, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  public function delete()
  {
    if ($this->shcedule->getId()) {
      $id = $this->shcedule->getId();
      $stmt = $this->dbh->prepare("UPDATE shcedule SET is_delete=1 WHERE id=:id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  public function find($id)
  {
    $stmt = $this->dbh->prepare("SELECT * FROM shcedule WHERE id=:id AND is_delete=0");
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

  public function findAll()
  {
    $stmt = $this->dbh->prepare("SELECT shcedule.id,shcedule.title,shcedule.body,shcedule.study_day,shcedule.user_id,shcedule.is_delete FROM shcedule 
    INNER JOIN users ON
    shcedule.user_id = users.id 
    WHERE is_delete=0 ORDER BY created_at DESC");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // print_r($results);

    $shcedules = array();
    foreach ($results as $result) {
      $shcedule = new Shcedule();
      $shcedule->setId($result['id']);
      $shcedule->setTitle($result['title']);
      $shcedule->setBody($result['body']);
      $shcedule->setStudyDay($result['study_day']);
      $shcedule->setUser_id($result['user_id']);
      $shcedule->setCreatedAt($result['created_at']);
      $shcedule->setUpdatedAt($result['updated_at']);
      $shcedules[] = $shcedule;
    }

    return $shcedules;
  }

  public function findAllDate($id)
  {
    $stmt = $this->dbh->prepare("SELECT shcedule.id,shcedule.title,shcedule.body,shcedule.study_day,shcedule.user_id,shcedule.is_delete FROM shcedule 
    LEFT JOIN users ON
    shcedule.user_id = users.id
    WHERE is_delete=0 AND user_id=:id  ORDER BY created_at DESC");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);


    $shcedules = array();
    foreach ($results as $result) {
      $shcedule = new Shcedule();
      $shcedule->setId($result['id']);
      $shcedule->setTitle($result['title']);
      $shcedule->setBody($result['body']);
      $shcedule->setStudyDay($result['study_day']);
      $shcedule->setCreatedAt($result['created_at']);
      $shcedule->setUpdatedAt($result['updated_at']);
      $shcedules[] = $shcedule;
    }
    return $shcedules;
  }

  // public function carenderScheduleRegister()
  // {
  //   $stmt = $this->dbh->prepare("SELECT * FROM shcedule WHERE is_delete=0 ");
  //   $stmt->execute();
  //   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // }
}
