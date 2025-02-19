<?php 


class ObjectifNameModel extends CoreModel{
    private $_req; 

    public function getAllObjectif(){
        $sql = "SELECT *
        FROM 
        nameobjectif ";

        try {
            if (($this->_req = $this->getDb()->query($sql)) !== false) 
            {
                $dataObjectives = $this->_req->fetchAll();
            }
        
            return $dataObjectives; 

        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

}