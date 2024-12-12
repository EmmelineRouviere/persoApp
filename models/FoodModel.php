<?php


class FoodModel extends CoreModel
{
    private $_req; 

    public function __destruct()
    {
      if (!empty($this->_req)) 
      {
        $this->_req->closeCursor();
      }
    }
  

    public function getAllFood()
    {
        $sql = "SELECT *
            FROM 
            food
            ";

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


    public function getOneFood($idUrl)
    {
        try {

            $sql = "SELECT *
            FROM 
                food
            WHERE 
                foo_id = :idUrl";

            $datas = $this->makeSelect($sql, ['idUrl'=> $idUrl]);
            return $datas; 
        

        } catch (PDOException $e) {

            die($e->getMessage());
        }
        
    }


    public function addFood($namefood, $proteines, $lipides, $glucides, $calories)
    {
        try {

            $sql = "INSERT INTO FOOD (
            foo_namefood, foo_proteines, foo_lipides, foo_glucides, foo_calories) VALUES (
            :namefood,
            :proteines,
            :lipides,
            :glucides,
            :calories)";

            if($datas = $this->makeRequest($sql, ['namefood'=> $namefood, 'proteines'=>$proteines, 'lipides'=>$lipides, 'glucides'=>$glucides, 'calories'=>$calories]) === false)
            {
            $error = 'Impossible d\'ajouter l\'aliment';
            }

            header('Location: index.php?ctrl=food&action=index');
            

        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }


    public function getFoodBySearch($userInput)
    {
        $sql = "SELECT *
                FROM FOOD
                WHERE foo_namefood LIKE :searchTerm
                ORDER BY foo_namefood ASC";

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

    public function getFoodByMeal($idUrl)
    {
        try {

            $sql = "SELECT f.foo_id, f.foo_namefood, mf.foo_quantity, f.foo_calories, f.foo_lipides, f.foo_glucides, f.foo_proteines
                    FROM meal m
                    JOIN composing mf ON m.mea_id = mf.mea_id
                    JOIN food f ON mf.foo_id = f.foo_id
                    WHERE m.mea_id = :idUrl;";

           $datas = $this->makeSelect($sql, ['idUrl'=> $idUrl]);
           return $datas; 
        

        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }
    
    public function updateFood($idUrl, $namefood, $proteines, $lipides, $glucides, $calories)
    {
    $sql = 'UPDATE FOOD SET
                foo_namefood = :namefood, 
                foo_proteines = :proteines, 
                foo_lipides = :lipides, 
                foo_glucides = :glucides, 
                foo_calories = :calories
            WHERE foo_id = :idUrl';

        if($datas = $this->makeRequest($sql, ['idUrl'=>$idUrl, 'namefood'=> $namefood, 'proteines'=>$proteines, 'lipides'=>$lipides, 'glucides'=>$glucides, 'calories'=>$calories]) === false)
        {
        $error = 'Impossible d\'ajouter l\'aliment';
        }

        header('Location: index.php?ctrl=food&action=index');
    

        

    }


    public function deleteFood($idUrl)
    {

        try {
            $sql = 'DELETE FROM food WHERE foo_id = :idUrl';

            $result = $this->makeRequest($sql, ['idUrl'=>$idUrl]);

            return $result;
        } catch (Exception $e) {
        }

    }

}