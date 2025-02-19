<?php


class DaymealModel extends CoreModel
{
    private $_req;

    public function __destruct()
    {
        if (!empty($this->_req)) {
            $this->_req->closeCursor();
        }
    }

    public function getInformationForCurrentDay($userId){
        try{
        $sql = "SELECT 
        use_id, 
        day_date,
        ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS tot_totalProteines,
        ROUND(SUM(f.foo_lipides * mf.foo_quantity / 100), 2) AS tot_totalLipides,
        ROUND(SUM(f.foo_glucides * mf.foo_quantity / 100), 2) AS tot_totalGlucides,
        ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS tot_totalCalories
        FROM daymeal
        JOIN daymeal_meal USING (day_id)
        JOIN food_meal mf USING (mea_id)
        JOIN food f USING (foo_id)
        WHERE use_id = :userId AND day_date = CURDATE()
        GROUP BY use_id, day_date;";
        $datas = $this->makeSelect($sql, ['userId' => $userId]);
        return $datas;

        }catch (PDOException $e) {

            die($e->getMessage());
        }
    } 

    public function getAllByUserCurrentDay($userId){
        try{

            $sql="SELECT u.use_id, day_id AS day_dayId, day_date, mea_id AS mea_mealId, nam_id, nam_label AS nam_nameMeal, m.mea_nameMeal AS mea_mealName, mea_descriptionMeal, 
                    ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS mea_totalProteines,
                    ROUND(SUM(f.foo_lipides * mf.foo_quantity / 100), 2) AS mea_totalLipides,
                    ROUND(SUM(f.foo_glucides * mf.foo_quantity / 100), 2) AS mea_totalGlucides,
                    ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS mea_totalCalories
                FROM daymeal_meal dm
                LEFT JOIN daymeal d USING (day_id) 
                LEFT JOIN namemeal nm USING(nam_id)
                LEFT JOIN user u USING (use_id) 
                LEFT JOIN food_meal mf USING (mea_id)
                LEFT JOIN food f USING (foo_id)
                LEFT JOIN meal m USING (mea_id)
                WHERE u.use_id = :userId 
                    AND day_date = CURDATE() 
                GROUP BY use_id, day_id, day_date, mea_id, nam_id, nam_label";


            $datas = $this->makeSelect($sql, ['userId' => $userId]);
            return $datas;

        }catch (PDOException $e) {

            die($e->getMessage());
        }
    }


    public function addDaymeal($userId, $date, $namemeals, $meal)
{
    try {

        $sql = "INSERT INTO daymeal (day_date, use_id) 
                VALUES ( :date, :userId)";

        $this->makeRequest($sql, ['date' => $date, 'userId' => $userId]);
        
        $dayId = $this->getDb()->lastInsertId();

      
            $sqlFood = "INSERT INTO daymeal_meal (mea_id, day_id, nam_id) 
                        VALUES (:meal, :day_id, :namemeal)";

            
                $this->makeRequest($sqlFood, [
                    'meal' => $meal,
                    'day_id' => $dayId,
                    'namemeal' => $namemeals
                ]);
            
        
        return true;

    } catch (PDOException $e) {
        $this->getDb()->rollBack();
        throw new Exception("Erreur lors de l'ajout du repas : " . $e->getMessage());
    }
}


public function deleteDaymeal($idUrl)
    {

        try {
            $sqlDaymeal = 'DELETE FROM daymeal_meal WHERE day_id = :idUrl';

          if($sqlDaymeal = $this->makeRequest($sqlDaymeal, ['idUrl'=>$idUrl]) === true){
                $sqlMeal = 'DELETE FROM daymeal WHERE day_id = :idUrl'; 

                $resultMeal = $this->makeRequest($sqlDaymeal, ['idUrl'=>$idUrl]);
          } 

            return $resultMeal;
        } catch (Exception $e) {
        }

    }

}