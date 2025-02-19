<?php 


class ObjectifModel extends CoreModel{
    private $_req; 


    public function getAllObjectif(){

        $sql = "SELECT use_id,obj_weightObjectif, obj_workoutObjectifPerWeek, obj_state,
            nam_label
            FROM user u
            LEFT JOIN objectif USING (use_id)
            LEFT JOIN nameobjectif USING(nam_id)";

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

    public function getAllObjectifByUser($userId){

        try {
            $sql = "SELECT use_id,obj_weightObjectif, obj_workoutObjectifPerWeek, obj_state,
            nam_label
            FROM user u
            LEFT JOIN objectif USING (use_id)
            LEFT JOIN nameobjectif USING(nam_id)
            WHERE u.use_id = :idUrl; ";

            $datas = $this->makeSelect($sql, ['idUrl'=> $userId]);
     
            return $datas; 

        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }
    public function getOneObjectif($objectifId){

        try {
            $sql = "SELECT use_id as use_userId, obj_weightObjectif, obj_workoutObjectifPerWeek, obj_state as obj_objectifState,
            nam_label as obj_objectifLabel, nam_id as obj_objectifLabelId,  obj_id as obj_objectifId
            FROM user 
            LEFT JOIN objectif USING (use_id)
            LEFT JOIN nameobjectif USING(nam_id)
            WHERE obj_id = :idUrl";

            $datas = $this->makeSelect($sql, ['idUrl'=> $objectifId]);
     
            return $datas; 

        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

    public function create($userData){
        try{
            $sqlObjectif = "INSERT INTO objectif (obj_weightObjectif, obj_workoutObjectifPerWeek, obj_state, use_id, nam_id)
            VALUES (:weightObjectif, :workoutObjectifPerWeek, :state, :userId, :objectif)";
    
            $paramsObjectif = [
                'userId' => $userData['userId'],
                'objectif' => $userData['objectif'],
                'weightObjectif' => $userData['weightObjectif'] !== '' ? $userData['weightObjectif'] : null,
                'workoutObjectifPerWeek' => $userData['workoutObjectifPerWeek'] !== '' ? $userData['workoutObjectifPerWeek'] : null,
                'state' => $userData['state'],
            ];
    
            $resultObjectif = $this->makeRequest($sqlObjectif, $paramsObjectif);
    
            if($resultObjectif === false){
                throw new Exception('Impossible de rajouter cet objectif');
            } else {
                return true; 
            }
        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout de l'objectif : " . $e->getMessage());
            throw $e; // Relancer l'exception pour qu'elle soit gérée par le contrôleur
        }
    }
    
    public function update($objectifId, $userData)
    {
        try {
            $sqlObjectif = "UPDATE objectif 
                            SET obj_weightObjectif = :weightObjectif, 
                                obj_workoutObjectifPerWeek = :workoutObjectifPerWeek, 
                                obj_state = :state, 
                                nam_id = :objectif
                            WHERE obj_id = :objectifId AND use_id = :userId";
    
            $paramsObjectif = [
                'objectifId' => $objectifId,
                'userId' => $userData['userId'],
                'objectif' => $userData['objectif'],
                'weightObjectif' => $userData['weightObjectif'] !== '' ? $userData['weightObjectif'] : null,
                'workoutObjectifPerWeek' => $userData['workoutObjectifPerWeek'] !== '' ? $userData['workoutObjectifPerWeek'] : null,
                'state' => $userData['state'],
            ];
    
            $resultObjectif = $this->makeRequest($sqlObjectif, $paramsObjectif);
    
            if ($resultObjectif === false) {
                throw new Exception('Impossible de modifier cet objectif');
            } else {
                return true;
            }
        } catch (Exception $e) {
            error_log("Erreur lors de la modification de l'objectif : " . $e->getMessage());
            throw $e; // Relancer l'exception pour qu'elle soit gérée par le contrôleur
        }
    }

}