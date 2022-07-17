<?php
class Memo
{
  private $id;
  private $memo_body;
  private $shcedule_id;

  public function getId()
  {
    return $this->id;
  }

  public function getMemo_body()
  {
    return $this->memo_body;
  }

  public function getShcedule_id()
  {
    return $this->shcedule_id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function setMemo_body($memo_body)
  {
    $this->memo_body = $memo_body;
  }

  public function setShcedule_id($shcedule_id)
  {
    $this->shcedule_id = $shcedule_id;
  }
}
