<?php 

class HealthdataModel extends CoreModel{
    private $_req; 


    public function getAllHealthdataByUser($userId){
        try {
            $sql = "SELECT *, use_sexe, use_birthday
            FROM healthdata
            LEFT JOIN user USING(use_id)
            WHERE use_id = :idUrl; ";

            $datas = $this->makeSelect($sql, ['idUrl'=> $userId]);
     
            return $datas; 

        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

        
    

}