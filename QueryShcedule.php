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
      $user_id = $this->shcedule->getUser_Id();
      $stmt = $this->dbh->prepare("INSERT INTO shcedule (title,body,study_day,user_id,created_at,updated_at)
        VALUES (:title,:body,:study_day,:user_id,NOW(),NOW())");
      $stmt->bindParam(":title", $title, PDO::PARAM_STR);
      $stmt->bindParam(":body", $body, PDO::PARAM_STR);
      $stmt->bindParam(":study_day", $study_day, PDO::PARAM_STR);
      $stmt->bindParam(":user_id", $user_id, PDO::PARAM_STR);
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
      $shcedule->setIs_done($result["is_done"]);
    }
    return $shcedule;
  }

  public function scheduleOneDay($study_day, $id)
  {
    $stmt = $this->dbh->prepare("SELECT * FROM shcedule WHERE study_day=:study_day AND user_id =:user_id  AND is_delete=0");
    $stmt->bindParam(':study_day', $study_day, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $shcedules = array();
    foreach ($results as $result) {
      $shcedule = new Shcedule();
      $shcedule->setId($result['id']);
      $shcedule->setTitle($result['title']);
      $shcedule->setBody($result['body']);
      $shcedule->setUser_id($result['user_id']);
      $shcedule->setStudyDay($result['study_day']);
      $shcedule->setCreatedAt($result['created_at']);
      $shcedule->setUpdatedAt($result['updated_at']);
      $shcedule->setIs_done($result["is_done"]);
      $shcedules[] = $shcedule;
    }
    return $shcedules;
  }


  public function findAllMemo($id)
  {
    $stmt = $this->dbh->prepare("SELECT memo.id , memo.memo_body , memo.shcedule_id FROM memo WHERE shcedule_id=:id ");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($results);
    $memos = array();
    foreach ($results as $result) {
      $memo = new Memo();
      $memo->setId($result['id']);
      $memo->setMemo_body($result['memo_body']);
      $memo->setShcedule_id($result['shcedule_id']);
      $memos[] = $memo;
    }

    return $memos;
  }

  public function findAll()
  {
    $stmt = $this->dbh->prepare("SELECT shcedule.id,shcedule.title,shcedule.body,shcedule.study_day,shcedule.user_id,shcedule.is_delete,is_done,created_at,updated_at FROM shcedule 
    INNER JOIN users ON
    shcedule.user_id = users.id 
    WHERE is_delete=0 AND DATE_FORMAT(created_at, '%Y%m') = DATE_FORMAT(NOW(), '%Y%m')
    ORDER BY created_at DESC");
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
      $shcedule->setIs_done($result['is_done']);
      $shcedules[] = $shcedule;
    }

    return $shcedules;
  }



  public function findAllDate($id)
  {
    $stmt = $this->dbh->prepare("SELECT shcedule.id,shcedule.title,shcedule.body,shcedule.study_day,shcedule.user_id,shcedule.is_delete,shcedule.is_done,created_at,updated_at FROM shcedule 
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
      $shcedule->setIs_done($result['is_done']);
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
