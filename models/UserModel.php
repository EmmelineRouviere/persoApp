<?php 


class UserModel extends CoreModel {
    private $_req; 

    public function __destruct()
    {
      if (!empty($this->_req)) 
      {
        $this->_req->closeCursor();
      }
    }


    public function connexion()
    {
        $request = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        try {
            $sql = "SELECT *,
                FROM user
                WHERE use_email = :email";
            if (!empty($request['email']) && !empty($request['password'])) {
                if (($this->_req = $this->getDb()->prepare($sql)) !== false) {
                    if($this->_req->bindValue(':email', $request['email'], PDO::PARAM_STR)) {
                        if ($this->_req->execute()) {
                            $user = $this->_req->fetch(PDO::FETCH_ASSOC);
                            if ($user && password_verify($request['password'], $user['use_password'])) {
                                unset($user['use_password']);
                                return $user;
                            }
                        }
                    }
                }
            }
            return false;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


    public function createNewUser($firstname, $lastname, $email, $pwd, $birthday, $town, $sexe, $actualWeight, $height, $weightObjectif, $workoutObjectifPerWeek)
    {
        try {
            $sql = 'INSERT INTO USER (use_firstname, use_lastname, use_email, use_password, use_birthday, use_town, use_sexe, rol_id)
VALUES (:firstname, :lastname, :email, :birthday, :town, :sexe, :role_id);';

            $passwordHash = password_hash($pwd, PASSWORD_DEFAULT);

            $params = [
                'use_firstname' => $firstname,
                'use_lastname' => $lastname,
                'use_email' => $email,
                'use_password' => $passwordHash,
                'use_birthday' => $birthday,
                'use_town' => $town,
                'use_sexe' => $sexe,
                'rol_id' => 1
            ];

            $result = $this->makeRequest($sql, $params);

            if ($result === false) {
                throw new Exception('Impossible de créer ce nouvel user');
            }else{
                $userId = $this->getDb()->lastInsertId();

            if (isset($_POST['actualWeight']) && isset($_POST['height'])) {
                $sqlHealthData = "INSERT INTO HEALTHDATA (hea_actualWeight, hea_height, hea_weightObjectif, hea_workoutObjectifPerWeek, use_id)
                VALUES (:actual_weight, :height, :weight_objective, :workout_objective, :use_id);";

                $params = [
                    'hea_actuelWheight' => $actualWeight,
                    'hea_height' => $height,
                    'hea_weightObjectif' => $weightObjectif,
                    'hea_workoutObjectifPerWeek' => $workoutObjectifPerWeek,
                    'use_Id' => $userId,
                ];
                $resultHealthData = $this->makeRequest($sql, $params);
                
                if($resultHealthData === false){
                    throw new Exception('Impossible de créer ce nouvel user');
                }else{

                    if( isset($_POST['objectf'])){
                        $sqlObectif = "INSERT INTO USER_OBJECTIF (use_id, obj_id, uob_state)
                        VALUES (@user_id, :objective_id, :objective_state);";
                    }
                }

                header('Location: index.php?ctrl=student&action=show&id=' . $userId);
            }

            // Redirection en cas de succès
            header('Location: index.php?ctrl=student&action=index');
            exit();


            }
                        
        } catch (Exception $e) {
            // Log l'erreur
            error_log("Erreur lors de l'ajout d'un étudiant : " . $e->getMessage());
            exit();
        }

    }
}