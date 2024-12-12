<?php


class MealModel extends CoreModel
{
    private $_req; 

    public function __destruct()
    {
      if (!empty($this->_req)) 
      {
        $this->_req->closeCursor();
      }
    }
  

    public function getAllMeal()
    {
        $sql = "SELECT m.mea_id, m.mea_nameMeal, 
                ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS mea_totalProteines,
                ROUND(SUM(f.foo_lipides * mf.foo_quantity / 100), 2) AS mea_totalLipides,
                ROUND(SUM(f.foo_glucides * mf.foo_quantity / 100), 2) AS mea_totalGlucides,
                ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS mea_totalCalories
                    FROM meal m
                    JOIN composing mf ON m.mea_id = mf.mea_id
                    JOIN food f ON mf.foo_id = f.foo_id
                    GROUP BY m.mea_id, m.mea_nameMeal;";

        try {
            if (($this->_req = $this->getDb()->query($sql)) !== false) 
            {
                $dataFood = $this->_req->fetchAll();
            }
        
            return $dataFood; 

        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }


    public function getOneMeal($idUrl)
    {
        try {

            $sql = "SELECT m.mea_id, m.mea_nameMeal, m.mea_descriptionMeal, f.foo_namefood, mf.foo_quantity,
                ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS mea_totalProteines,
                ROUND(SUM(f.foo_lipides * mf.foo_quantity / 100), 2) AS mea_totalLipides,
                ROUND(SUM(f.foo_glucides * mf.foo_quantity / 100), 2) AS mea_totalGlucides,
                ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS mea_totalCalories
                    FROM meal m
                    JOIN composing mf ON m.mea_id = mf.mea_id
                    JOIN food f ON mf.foo_id = f.foo_id
                    WHERE m.mea_id = :idUrl
                    GROUP BY m.mea_id, m.mea_nameMeal;";

            $datas = $this->makeSelect($sql, ['idUrl'=> $idUrl]);
            return $datas; 
        

        } catch (PDOException $e) {

            die($e->getMessage());
        }
        
    }

    

    public function addMeal($name, $description, $foods)
{
    try {
        $this->getDb()->beginTransaction();

        $sql = "INSERT INTO MEAL (mea_nameMeal, mea_descriptionMeal, use_id) 
                VALUES (:nameMeal, :descriptionMeal, 1)";

        $this->makeRequest($sql, ['nameMeal' => $name, 'descriptionMeal' => $description]);
        
        $mealId = $this->getDb()->lastInsertId();

        if (is_array($foods)) {
            $sqlFood = "INSERT INTO composing (mea_id, foo_id, foo_quantity) 
                        VALUES (:mea_id, :foo_id, :foo_quantity)";

            foreach ($foods as $food) {
                $this->makeRequest($sqlFood, [
                    'mea_id' => $mealId,
                    'foo_id' => $food['id'],
                    'foo_quantity' => $food['quantity']
                ]);
            }
        }

        $this->getDb()->commit();
        return true;

    } catch (PDOException $e) {
        $this->getDb()->rollBack();
        throw new Exception("Erreur lors de l'ajout du repas : " . $e->getMessage());
    }
}


    public function getMealBySearch($userInput)
    {
        $sql = "SELECT DISTINCT m.*
        FROM meal m
        LEFT JOIN composing mf ON m.mea_id = mf.mea_id
        LEFT JOIN food f ON mf.foo_id = f.foo_id
        WHERE 
            EXISTS (
                SELECT 1
                FROM composing mf2
                JOIN food f2 ON mf2.foo_id = f2.foo_id
                WHERE mf2.mea_id = m.mea_id AND f2.foo_namefood LIKE :searchTerm
            )
            OR m.mea_nameMeal LIKE ':searchTerm'";

        try {

         $pdo = $this->getDb(); 

         if(($request = $pdo->prepare($sql)) !== false)
         {
            if($request->execute(['searchTerm'=>$userInput])){
                return $request;
              }else{
                return false;
              }
         }

        } catch (PDOException $e) {

            die($e->getMessage());
        }

    }

    
    
    public function updateMeal($mealId, $name, $description, $foods)
    {
        
        try {
    
            $sql = "UPDATE MEAL SET mea_nameMeal = :nameMeal, mea_descriptionMeal = :descriptionMeal WHERE mea_id = :mealId";
            $this->makeRequest($sql, ['nameMeal' => $name, 'descriptionMeal' => $description, 'mealId' => $mealId]);
    

            $sqlDelete = "DELETE FROM composing WHERE mea_id = :mealId";
            $this->makeRequest($sqlDelete, ['mealId' => $mealId]);
    

            if (is_array($foods)) {
                $sqlFood = "INSERT INTO composing (mea_id, foo_id, foo_quantity) VALUES (:mea_id, :foo_id, :foo_quantity)";
                foreach ($foods as $food) {
                    $this->makeRequest($sqlFood, [
                        'mea_id' => $mealId,
                        'foo_id' => $food['id'],
                        'foo_quantity' => $food['quantity']
                    ]);
                }
            }
            return true;
        } catch (PDOException $e) {
            $this->getDb()->rollBack();
            throw new Exception("Erreur lors de la mise à jour du repas : " . $e->getMessage());
        }
        
    

        

    }


    public function deleteMeal($idUrl)
    {

        try {
            $sqlFood = 'DELETE FROM composing WHERE mea_id = :idUrl';

          if($resultFood = $this->makeRequest($sqlFood, ['idUrl'=>$idUrl]) === true){
                $sqlMeal = 'DELETE FROM composing WHERE mea_id = :idUrl'; 

                $resultMeal = $this->makeRequest($sqlFood, ['idUrl'=>$idUrl]);
          } 

            return $resultMeal;
        } catch (Exception $e) {
        }

    }

}