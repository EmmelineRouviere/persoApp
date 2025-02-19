<?php


class UserModel extends CoreModel
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
     * Authenticates a user and updates their last login time
     *
     * @param array $request The POST data containing 'email' and 'password'
     * @return array|false Returns user data if authentication is successful, false otherwise
     */
    public function connexion($request)
    {
        $request = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        try {
            $sql = "SELECT * FROM user 
            WHERE use_email = :email";
            if (!empty($request['email']) && !empty($request['password'])) {
                $stmt = $this->getDb()->prepare($sql);
                $stmt->bindValue(':email', $request['email'], PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($request['password'], $user['use_password'])) {
                    // Update date lastlogin
                    $updateSql = "UPDATE user SET use_lastLogIn = :lastLogin WHERE use_id = :userId";
                    $updateStmt = $this->getDb()->prepare($updateSql);
                    $updateStmt->bindValue(':lastLogin', date('Y-m-d H:i:s'), PDO::PARAM_STR);
                    $updateStmt->bindValue(':userId', $user['use_id'], PDO::PARAM_INT);
                    $updateStmt->execute();
                    unset($user['use_password']);
                    return $user;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Erreur de connexion : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all users with their basic informations and health data
     *
     * @return array|null An array of all users' data or null if no users found
     * @throws PDOException If a database error occurs
     */

    public function getAllUsers(): array
    {
        try {
            $sql = "SELECT use_id, use_firstname, use_lastname, use_email, use_birthday, use_sexe, hea_actualWeight, hea_height
            FROM USER
            LEFT JOIN healthdata USING (use_id) ";

            $datas = $this->makeSelect($sql);
            return $datas;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

    /**
     * Get informations for a specific user by their ID
     *
     * @param int $userId The ID of the user to retriev
     * @return array|null An array of the user's data or null if user not found
     * @throws PDOException If a database error occurs
     */

    public function getOneUser($userId): array
    {

        try {
            $sql = "SELECT use_id, use_firstname, use_lastname, use_email, use_birthday, use_sexe, rol_id AS use_roleId 
            FROM USER 
            WHERE use_id = :userId";

            $datas = $this->makeSelect($sql, ['userId' => $userId]);
            return $datas;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

    /**
     * Retrieves detailed profile information for a specific user by their ID
     *
     * @param int $userId The ID of the user whose profile to retrieve
     * @return array|null An array of the user's profile data or null if user not found
     * @throws PDOException If a database error occurs
     */

    public function getOneProfil(int $userId): array
    {
        try {
            $sql = "SELECT use_id, use_lastname, use_firstname, use_email, hea_actualWeight, use_birthday, use_sexe, hea_height, obj_id AS obj_objectifId, 
            obj_weightObjectif, obj_workoutObjectifPerWeek, nam_label AS nam_objectifLabel, rol_id AS use_roleId 
            FROM USER 
            LEFT JOIN HEALTHDATA USING (use_id) 
            LEFT JOIN OBJECTIF USING (use_id) 
            LEFT JOIN nameobjectif USING (nam_id)
            WHERE use_id = :userId";

            $datas = $this->makeSelect($sql, ['userId' => $userId]);
            return $datas;
        } catch (PDOException $e) {

            die($e->getMessage());
        }
    }

    /**
     * Creates a new user with associated health data
     *
     * @param array $userData An array containing user information (email, pwd, confirmPwd, actualWeight, height, firstname, lastname, sexe, birthday)
     * @return bool True if user creation is successful
     * @throws Exception If any validation fails or database operations encounter errors
     */
    public function createUser(array $userData): bool
    {
        try {

            if (empty($userData['email'])) {
                throw new Exception("Veuillez renseigner un email");
            } else {
                $sqlEmail = "SELECT use_id FROM user WHERE use_email = :email";

                $resultEmail = $this->makeRequest($sqlEmail, ['email' => $userData['email']]);

                if ($resultEmail->rowCount() === 1) {
                    throw new Exception("Cet email est dèjà utilisé");
                }
            }

            if (empty($userData['pwd'])) {
                throw new Exception("Veuillez renseigner un mot de passe valide");
            } else {
                if (strlen($userData['pwd']) < 8) {
                    throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
                }
                if ($userData['pwd'] !== $userData['confirmPwd']) {
                    throw new Exception("Les mots de passe ne correspondent pas");
                }
            }

            if (empty($userData['actualWeight']) || empty($userData['height'])) {
                throw new Exception("La taille et le poids doivent être renseignés");
            } else {
                if (!is_numeric($userData['actualWeight']) || !is_numeric($userData['height'])) {
                    throw new Exception("La taille et le poids doivent être des valeurs numériques");
                }
            }

            if (empty($userData['firstname']) || empty($userData['lastname'])) {
                throw new Exception("Le nom et prénom doivent être renseignés");
            } else {
                if (is_numeric($userData['firstname']) || is_numeric($userData['lastname'])) {
                    throw new Exception("Le nom et prénom doivent être composé uniquement de texte");
                }
            }
            if (empty($userData['sexe'])) {
                throw new Exception("Veuillez renseigner votre sexe");
            }

            $sanitizedData = $this->sanitizeData($userData);

            // Hash password
            $passwordHash = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

            // Prepare user data for insertion
            $userParams = [
                'firstname' => $sanitizedData['firstname'],
                'lastname' => $sanitizedData['lastname'],
                'email' => $sanitizedData['email'],
                'password' => $passwordHash,
                'birthday' => $sanitizedData['birthday'],
                'sexe' => $sanitizedData['sexe'],
                'roleId' => 1
            ];

            // Insert user data
            $sql = 'INSERT INTO USER (use_firstname, use_lastname, use_email, use_password, use_birthday, use_sexe, rol_id)
                        VALUES (:firstname, :lastname, :email, :password, :birthday, :sexe, :roleId)';

            $result = $this->makeRequest($sql, $userParams);

            if ($result === false) {
                throw new Exception('Impossible de créer ce nouvel utilisateur');
            }

            $userId = $this->getDb()->lastInsertId();

            // Insert health data
            $healthDataParams = [
                'actualWeight' => $sanitizedData['actualWeight'],
                'height' => $sanitizedData['height'],
                'userId' => $userId,
            ];

            $sqlHealthData = "INSERT INTO HEALTHDATA (hea_actualWeight, hea_height, use_id)
                                VALUES (:actualWeight, :height, :userId)";

            $resultHealthData = $this->makeRequest($sqlHealthData, $healthDataParams);

            if ($resultHealthData === false) {
                throw new Exception('Impossible de créer les données de santé');
            }

            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de l'ajout d'un utilisateur : " . $e->getMessage());
            throw $e; // Re-throw the exception to be handled in the controller
        }
    }

    /**
     * Updates user information and associated health data
     *
     * @param int $userId The ID of the user to update
     * @param array $userData An array containing updated user information (firstname, lastname, email, birthday, sexe, actualWeight, height, pwd, pwdConfirm)
     * @return bool True if update is successful, false otherwise
     * @throws Exception If validation fails or database operations encounter errors
     */

    public function updateUser(int $userId, array $userData): bool
    {
        try {
            if (!is_numeric($userData['actualWeight']) || !is_numeric($userData['height'])) {
                throw new Exception("La taille et le poids doivent être des valeurs numériques");
            }

            // Sanitize input data
            $sanitizedData = $this->sanitizeData($userData);

            // Prepare user data for update
            $userParams = [
                'firstname' => $sanitizedData['firstname'],
                'lastname' => $sanitizedData['lastname'],
                'email' => $sanitizedData['email'],
                'birthday' => $sanitizedData['birthday'],
                'sexe' => $sanitizedData['sexe'],
                'userId' => $userId
            ];

            // Update user data
            $sql = 'UPDATE USER SET 
                use_firstname = :firstname, 
                use_lastname = :lastname, 
                use_email = :email, 
                use_birthday = :birthday, 
                use_sexe = :sexe
                WHERE use_id = :userId';

            $result = $this->makeRequest($sql, $userParams);

            if ($result === false) {
                throw new Exception('Impossible de mettre à jour cet utilisateur');
            }

            // Update health data
            $healthDataParams = [
                'actualWeight' => $sanitizedData['actualWeight'],
                'height' => $sanitizedData['height'],
                'userId' => $userId,
            ];

            $sqlHealthData = "UPDATE HEALTHDATA SET 
                          hea_actualWeight = :actualWeight, 
                          hea_height = :height
                          WHERE use_id = :userId";

            $resultHealthData = $this->makeRequest($sqlHealthData, $healthDataParams);

            if ($resultHealthData === false) {
                throw new Exception('Impossible de mettre à jour les données de santé');
            }

            // Optional password change handling
            if (!empty($sanitizedData['pwd']) && !empty($sanitizedData['pwdConfirm'])) {
                if (strlen($sanitizedData['pwd']) >= 8 && $sanitizedData['pwd'] === $sanitizedData['pwdConfirm']) {
                    $passwordHash = password_hash($sanitizedData['pwd'], PASSWORD_DEFAULT);
                    $sqlPassword = "UPDATE USER SET use_password = :password WHERE use_id = :userId";
                    $resultPassword = $this->makeRequest($sqlPassword, ['password' => $passwordHash, 'userId' => $userId]);

                    if ($resultPassword === false) {
                        throw new Exception('Impossible de mettre à jour le mot de passe');
                    }
                } else {
                    throw new Exception('Le nouveau mot de passe est invalide ou ne correspond pas à la confirmation');
                }
            }

            return true;
        } catch (Exception $e) {
            error_log("Erreur lors de la mise à jour de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Deletes a user from the database
     *
     * @param int $userId The ID of the user to delete
     * @return bool True if deletion is successful, false otherwise
     * @throws Exception If a database error occurs during deletion
     */
    public function delete(int $userId): bool
    {
        try {
            $sqlUser = 'DELETE FROM user WHERE use_id = :idUrl';
            $resultUser = $this->makeRequest($sqlUser, ['idUrl' => $userId]);
            if ($resultUser !== false) {
                $sqlHealthData = 'DELETE FROM healthdata WHERE hea_id = :idUrl';
                $resultHealthData = $this->makeRequest($sqlHealthData, ['idUrl' => $userId]);
    
                if ($resultHealthData !== false) {
                    return true;
                }
            }
        } catch (Exception $e) {
            error_log("Erreur lors de la suppression de l'aliment : " . $e->getMessage());
            throw $e; // Re-throw the exception to be handled in the controller
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
            'firstname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'lastname' => FILTER_SANITIZE_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL,
            'birthday' => FILTER_SANITIZE_SPECIAL_CHARS,
            'sexe' => FILTER_SANITIZE_SPECIAL_CHARS,
            'actualWeight' => FILTER_SANITIZE_NUMBER_FLOAT,
            'height' => FILTER_SANITIZE_NUMBER_INT
        ];

        return filter_input_array(INPUT_POST, $filters);
    }
}
