<?php 

class NamemealModel extends CoreModel
{
    private $_req; 

    public function __destruct()
    {
      if (!empty($this->_req)) 
      {
        $this->_req->closeCursor();
      }
    }

    public function getAllNameMeal(){
        $sql = "SELECT * FROM NAMEMEAL;"; 

        try {
          if (($this->_req = $this->getDb()->query($sql)) !== false) 
          {
              $datas = $this->_req->fetchAll();
          }
      
          return $datas; 

      } catch (PDOException $e) {

          die($e->getMessage());
      }
  }
    


}