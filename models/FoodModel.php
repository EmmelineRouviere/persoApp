<?php


class FoodModel extends CoreModel
{
    private $_req;

    public function __destruct()
    {
        if (!empty($this->_req)) {
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
            if (($this->_req = $this->getDb()->query($sql)) !== false) {
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

            $datas = $this->makeSelect($sql, ['idUrl' => $idUrl]);
            return $datas;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }


    public function addFood($namefood, $proteines, $lipides, $glucides, $calories)
    {
        try {
            if(($proteines < 0) || ($lipides < 0) || ($glucides < 0) || ($calories < 0) ){
            // if((!isset($proteines)) || (!isset($lipides)) || (!isset($glucides)) || (!isset($calories)) ){
                throw new Exception("Protéines, lipides, Glucides et Calories doivent être renseignés (mettez 0 dans le cas où il n'y en n'a pas)");

            }else{
                if (!is_numeric($proteines) || !is_numeric($lipides) || !is_numeric($glucides) || !is_numeric($calories)) {
                    throw new Exception("Protéines, lipides, Glucides et Calories doivent être des valeurs numériques");
                }
            }
            
            if(empty($namefood)){
                throw new Exception("Votre aliment doit avoir un nom");
            }else{
                if (is_numeric($namefood)) {
                    throw new Exception("Le nom de l'aliment ne peut pas être composé que de chiffres");
                }
            }
            

            $sql = "INSERT INTO FOOD (
            foo_namefood, foo_proteines, foo_lipides, foo_glucides, foo_calories) VALUES (
            :namefood,
            :proteines,
            :lipides,
            :glucides,
            :calories)";

            $result = $this->makeRequest($sql, ['namefood' => $namefood, 'proteines' => $proteines, 'lipides' => $lipides, 'glucides' => $glucides, 'calories' => $calories]);

            if ($result === false) {
                throw new Exception("Erreur lors de l'ajout de l'aliment");
            }

            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout de l'aliment : " . $e->getMessage());
            throw $e; // Relancez l'exception pour la gérer dans le contrôleur
        }
    }



    public function getFoodBySearch($userInput)
    {
        $sql = "SELECT *
                FROM FOOD
                WHERE foo_namefood LIKE :searchTerm
                ORDER BY foo_namefood ASC";

        try {

            $datas = $this->makeSelect($sql, ['searchTerm' => $userInput]); 
            if($datas){
                return $datas;
            } else {
                    return false;
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
                    JOIN food_meal mf ON m.mea_id = mf.mea_id
                    JOIN food f ON mf.foo_id = f.foo_id
                    WHERE m.mea_id = :idUrl;";

            $datas = $this->makeSelect($sql, ['idUrl' => $idUrl]);
            return $datas;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

    public function updateFood($idUrl, $namefood, $proteines, $lipides, $glucides, $calories)
    {
        if (!is_numeric($proteines) || !is_numeric($lipides) || !is_numeric($glucides) || !is_numeric($calories)) {
            throw new Exception("Protéines, lipides, Glucides et Calories doivent être des valeurs numériques");
        }

        if (is_numeric($namefood)) {
            throw new Exception("Le nom de l'aliment ne peut pas être composé que de chiffres");
        }

        $sql = 'UPDATE FOOD SET
                foo_namefood = :namefood, 
                foo_proteines = :proteines, 
                foo_lipides = :lipides, 
                foo_glucides = :glucides, 
                foo_calories = :calories
            WHERE foo_id = :idUrl';

        if ($datas = $this->makeRequest($sql, ['idUrl' => $idUrl, 'namefood' => $namefood, 'proteines' => $proteines, 'lipides' => $lipides, 'glucides' => $glucides, 'calories' => $calories]) === false) {
            throw new Exception("Impossible de mettre l'aliment à jour");

        }

        header('Location: index.php?ctrl=food&action=index');
    }


    public function deleteFood($idUrl)
    {

        try {
            $sql = 'DELETE FROM food WHERE foo_id = :idUrl';

            $result = $this->makeRequest($sql, ['idUrl' => $idUrl]);

            return $result;
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression de l'aliment : " . $e->getMessage());
            throw $e; // Relancez l'exception pour la gérer dans le contrôleur
        }
    }
}
