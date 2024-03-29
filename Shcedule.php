<?php
class Shcedule
{
  private $id;
  private $title;
  private $body;
  private $study_day;
  private $user_id;
  private $created_at;
  private $updated_at;
  private $is_done;

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
  public function getUser_id()
  {
    return $this->user_id;
  }
  public function getCreatedAt()
  {
    return $this->created_at;
  }
  public function getUpdatedAt()
  {
    return $this->updated_at;
  }

  public function getIs_done()
  {
    return $this->is_done;
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
  public function setUser_id($user_id)
  {
    $this->user_id = $user_id;
  }
  public function setCreatedAt($created_at)
  {
    $this->created_at = $created_at;
  }

  public function setUpdatedAt($updated_at)
  {
    $this->updated_at = $updated_at;
  }
  public function setIs_done($is_done)
  {
    $this->is_done = $is_done;
  }
}
