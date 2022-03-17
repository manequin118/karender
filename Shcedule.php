<?php
class Shcedule
{
  private $id;
  private $title;
  private $body;
  private $study_day;
  private $created_at;
  private $updated_at;

  public function save()
  {
    $queryShcedule = new QueryShcedule();
    $queryShcedule->setShcedule($this);
    $queryShcedule->save();
  }

  public function delete()
  {
    $queryShcedule = new QueryShcedule();
    $queryShcedule->setShcedule($this);
    $queryShcedule->delete();
  }

  public function getId()
  {
    return $this->id;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function getBody()
  {
    return $this->body;
  }

  public function getStudyDay()
  {
    return $this->study_day;
  }
  public function getCreatedAt()
  {
    return $this->created_at;
  }
  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

  public function setId($id)
  {
    $this->id = $id;
  }
  public function setTitle($title)
  {
    $this->title = $title;
  }
  public function setBody($body)
  {
    $this->body = $body;
  }
  public function setStudyDay($study_day)
  {
    $this->study_day = $study_day;
  }
  public function setCreatedAt($created_at)
  {
    $this->created_at = $created_at;
  }

  public function setUpdatedAt($updated_at)
  {
    $this->updated_at = $updated_at;
  }
}
