<?php


class MealModel extends CoreModel
{
    private $_req;

    /**
     * Destructor: Closes the database cursor if a request is active
     */
    public function __destruct()
    {
        if (!empty($this->_req)) {
            $this->_req->closeCursor();
        }
    }

    /**
     * Retrieves all meals along with their nutritional information and owner details
     *
     * @return array An array of meals, each containing meal ID, name, total proteins, total lipids,
     *               total glucides, total calories, user ID of the meal owner, and owner's full name
     * @throws PDOException If a database error occurs during the query execution
     */

    public function getAllMeal(): array
    {
        $sql = "SELECT m.mea_id, m.mea_nameMeal, 
                ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS mea_totalProteines,
                ROUND(SUM(f.foo_lipides * mf.foo_quantity / 100), 2) AS mea_totalLipides,
                ROUND(SUM(f.foo_glucides * mf.foo_quantity / 100), 2) AS mea_totalGlucides,
                ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS mea_totalCalories, 
                use_id AS use_userId, CONCAT (use_lastname, ' ', use_firstname) AS use_mealOwner
                    FROM meal m
                    LEFT JOIN user USING (use_id)
                    JOIN food_meal mf ON m.mea_id = mf.mea_id
                    JOIN food f ON mf.foo_id = f.foo_id
                    GROUP BY m.mea_id, m.mea_nameMeal;";

        try {
            if (($this->_req = $this->getDb()->query($sql)) !== false) {
                $dataFood = $this->_req->fetchAll();
            }

            return $dataFood;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }


    /**
     * Retrieves all meals associated with a specific user along with their nutritional information
     *
     * @param int $userId The ID of the user whose meals are to be retrieved
     * @return array An array of meals, each containing meal ID, name, total proteins, total lipids,
     *               total glucides, and total calories for the specified user
     * @throws PDOException If a database error occurs during the query execution
     */
    public function getAllMealByUser(int $userId): array|null
    {
        $sql = "SELECT 
        m.mea_id, 
        m.mea_nameMeal, 
        ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS mea_totalProteines,
        ROUND(SUM(f.foo_lipides * mf.foo_quantity / 100), 2) AS mea_totalLipides,
        ROUND(SUM(f.foo_glucides * mf.foo_quantity / 100), 2) AS mea_totalGlucides,
        ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS mea_totalCalories
        FROM meal m
        JOIN food_meal mf ON m.mea_id = mf.mea_id
        JOIN food f ON mf.foo_id = f.foo_id
        WHERE m.use_id = :userId
        GROUP BY m.mea_id, m.mea_nameMeal;";

        try {
            $datas = $this->makeSelect($sql, ['userId' => $userId]);

            return $datas;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

    /**
     * Retrieves detailed information about a specific meal by its ID
     *
     * @param int $idUrl The ID of the meal to retrieve
     * @return array An array containing details of the meal, including meal ID, name, description,
     *               food names, quantities, and total nutritional values (proteins, lipids,
     *               glucides, calories)
     * @throws PDOException If a database error occurs during the query execution
     */


    public function getOneMeal(int $idUrl): array
    {
        try {

            $sql = "SELECT m.mea_id, m.mea_nameMeal, m.mea_descriptionMeal, f.foo_namefood, mf.foo_quantity,
                ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS mea_totalProteines,
                ROUND(SUM(f.foo_lipides * mf.foo_quantity / 100), 2) AS mea_totalLipides,
                ROUND(SUM(f.foo_glucides * mf.foo_quantity / 100), 2) AS mea_totalGlucides,
                ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS mea_totalCalories,
                    u.use_id as use_mealOwner
                    FROM meal m
                    JOIN food_meal mf ON m.mea_id = mf.mea_id
                    JOIN food f ON mf.foo_id = f.foo_id
                    JOIN user u ON m.use_id = u.use_id
                    WHERE m.mea_id = :idUrl
                    GROUP BY m.mea_id, m.mea_nameMeal;";

            $datas = $this->makeSelect($sql, ['idUrl' => $idUrl]);

            return $datas;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }


    /**
     * Adds a new meal to the database along with its associated food items
     *
     * @param int $userId The ID of the user adding the meal
     * @param string $name The name of the meal
     * @param string $description A description of the meal
     * @param array $foods An array of food items associated with the meal, each containing 'id' and 'quantity'
     * @return bool Returns true if the meal was successfully added, false otherwise
     * @throws Exception If validation fails or a database error occurs during the insertion process
     */
    public function addMeal(int $userId, string $name, string $description, array $foods): bool
    {
        try {

            if (empty($name)) {
                throw new Exception("Votre repas doit avoir un nom");
            } else {
                if (is_numeric($name)) {
                    throw new Exception("Le nom du repas ne peut pas être composé que de chiffres");
                }
            }

            foreach ($foods as $food) {

                if (($food['quantity'] <= 0)) {
                    throw new Exception("La quantité de votre aliment doit être supérieur à 0");
                } else {
                    if (!is_numeric($food['quantity'])) {
                        throw new Exception("La quantité de votre aliment doit être une valeur numérique");
                    }
                }
            }

            $sanitizedData = $this->sanitizeData([
                'userId' => $userId,
                'name' => $name,
                'description' => $description,
                'foods' => $foods
            ]);


            $sql = "INSERT INTO MEAL (mea_nameMeal, mea_descriptionMeal, use_id) 
                VALUES (:nameMeal, :descriptionMeal, :userId)";

            $this->makeRequest($sql, [
                'nameMeal' => $sanitizedData['name'],
                'descriptionMeal' => $sanitizedData['description'],
                'userId' => $sanitizedData['userId']
            ]);

            $mealId = $this->getDb()->lastInsertId();

            if (is_array($sanitizedData['foods'])) {
                $sqlFood = "INSERT INTO food_meal (mea_id, foo_id, foo_quantity) 
                        VALUES (:mea_id, :foo_id, :foo_quantity)";

                foreach ($sanitizedData['foods'] as $food) {
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
            throw new Exception("Erreur lors de l'ajout du repas : " . $e->getMessage());
        }
    }


    /**
     * Retrieves meals for a specific user based on a search term and an userId
     *
     * @param string $userInput The search term used to filter meals by name or associated food items
     * @param int $userId The ID of the user whose meals are being searched
     * @return array An array of meals that match the search criteria, or an empty array if no matches are found
     * @throws PDOException If a database error occurs during the query execution
     */

    public function getMealBySearch(string $userInput, int $userId): array
    {
        $sql = "SELECT DISTINCT m.mea_id, m.mea_nameMeal, m.mea_descriptionMeal,
                ROUND(SUM(f.foo_proteines * mf.foo_quantity / 100), 2) AS mea_totalProteines,
                ROUND(SUM(f.foo_calories * mf.foo_quantity / 100), 2) AS mea_totalCalories
                FROM meal m
                LEFT JOIN food_meal mf ON m.mea_id = mf.mea_id
                LEFT JOIN food f ON mf.foo_id = f.foo_id
                WHERE 
                m.use_id = :userId  
                AND (
                    EXISTS (
                        SELECT 1
                        FROM food_meal mf2
                        JOIN food f2 ON mf2.foo_id = f2.foo_id
                        WHERE mf2.mea_id = m.mea_id AND f2.foo_namefood LIKE :searchTerm
                    )
                    OR m.mea_nameMeal LIKE :searchTerm
                )";

        try {

            $datas = $this->makeSelect($sql, ['searchTerm' => $userInput, 'userId' => $userId]);
            if ($datas) {
                return $datas;
            }
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }


    /**
     * Updates an existing meal's details and associated food items in the database
     *
     * @param int $mealId The ID of the meal to be updated
     * @param string $name The new name of the meal
     * @param string $description The new description of the meal
     * @param array $foods An array of food items associated with the meal, each containing 'id' and 'quantity'
     * @return bool Returns true if the meal was successfully updated, false otherwise
     * @throws Exception If a database error occurs during the update process
     */


    public function updateMeal(int $mealId, string $name, string $description, array $foods): bool
    {

        try {


            $sql = "UPDATE MEAL SET mea_nameMeal = :nameMeal, mea_descriptionMeal = :descriptionMeal WHERE mea_id = :mealId";
            $this->makeRequest($sql, ['nameMeal' => $name, 'descriptionMeal' => $description, 'mealId' => $mealId]);


            $sqlDelete = "DELETE FROM food_meal WHERE mea_id = :mealId";
            $this->makeRequest($sqlDelete, ['mealId' => $mealId]);


            if (is_array($foods)) {
                $sqlFood = "INSERT INTO food_meal (mea_id, foo_id, foo_quantity) VALUES (:mea_id, :foo_id, :foo_quantity)";
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

    /**
     * Deletes a meal and its associated food items from the database
     *
     * @param int $idUrl The ID of the meal to be deleted
     * @return bool Returns true if the meal was successfully deleted, false if deletion failed
     * @throws Exception If a database error occurs during the deletion process
     */

    public function deleteMeal(int $idUrl): bool
    {
        try {

            $sqlFood = 'DELETE FROM food_meal WHERE mea_id = :idUrl';
            $resultFood = $this->makeRequest($sqlFood, ['idUrl' => $idUrl]);

            if ($resultFood !== false) {
                $sqlMeal = 'DELETE FROM meal WHERE mea_id = :idUrl';
                $resultMeal = $this->makeRequest($sqlMeal, ['idUrl' => $idUrl]);

                if ($resultMeal !== false) {
                    return true;
                }
            }

            return false;
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression du repas : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Sanitizes input data to prevent XSS and other injection attacks
     *
     * @param array $data The input data to sanitize
     * @return array The sanitized data
     */
    private function sanitizeData(array $data): array
    {
        $filters = [
            'userId' => FILTER_SANITIZE_NUMBER_INT,
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'description' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        $sanitizedData = filter_var_array($data, $filters);

        if (isset($data['foods']) && is_array($data['foods'])) {
            $sanitizedData['foods'] = array_map(function ($food) {
                return [
                    'id' => filter_var($food['id'] ?? null, FILTER_SANITIZE_NUMBER_INT),
                    'quantity' => filter_var($food['quantity'] ?? null, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION)
                ];
            }, $data['foods']);
        }

        return $sanitizedData;
    }
}
