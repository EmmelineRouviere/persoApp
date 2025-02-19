<?php

class UserController
{

    /**
     * Displays the login form and handles any existing errors
     *
     * @return void
     */
    public function displayFormConnexion(): void
    {
        $errors = $_SESSION['errors'] ?? [];
        unset($_SESSION['errors']);

        // Add errors in Session ErrorHandler
        foreach ($errors as $code => $message) {
            ErrorHandler::addError($code, $message);
        }

        include './views/User/connexion.php';
    }

    /**
     * Handles user login process
     *
     * @param array $request The login request data
     * @return void
     */
    public function logIn($request): void
    {
        try {
            $model = new UserModel();
            $user = $model->connexion($request);
            if ($user) {
                $_SESSION[APP_TAG]['connected'] = [
                    'id' => $user['use_id'],
                    'firstname' => $user['use_firstname'],
                    'lastname' => $user['use_lastname'],
                    'role' => $user['rol_id']

                ];

                header('Location: index.php?ctrl=user&action=connected');
                exit();
            } else {
                ErrorHandler::addError('auth', "Aucun utilisateur référencé sur ces identifiants");
                $errors = ErrorHandler::getErrors();
                $_SESSION['errors'] = $errors;
                header('Location: index.php?ctrl=user&action=displayFormConnexion');
                exit;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Displays the connected user's profile page
     *
     * @return void
     */
    public function connected(): void
    {

        
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $code => $message) {
                ErrorHandler::addError($code, $message);
            }
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION[APP_TAG]['connected'])) {
            $_SESSION['page'] = 'Profile';

            $userId = $_SESSION[APP_TAG]['connected']['id'];

            $userModel = new UserModel();

            $userData = $userModel->getOneProfil($userId);
            $user = new User($userData);

            $calorieNeeds = $user->calculateDailyCalories();

            $daymealModel = new DaymealModel;
            $daymealData = $daymealModel->getAllByUserCurrentDay($userId);

            if ($daymealData !== null && !empty($daymealData)) {
                if (!is_array($daymealData) || !isset($daymealData[0])) {
                    // Only one result
                    $daymeals[] = new Daymeal($daymealData);
                } else {
                    // Multiple results
                    foreach ($daymealData as $data) {
                        $daymeals[] = new Daymeal($data);
                    }
                }
            } else {
                // If no result 
                $daymeals = null;
            }

            $daymealInformationData = $daymealModel->getInformationForCurrentDay($_SESSION[APP_TAG]['connected']['id']);

            // Checking is data is nulln if not instance of daymeal 
            if ($daymealInformationData !== null) {
                $daymealInformation = new Daymeal($daymealInformationData);
            } else {
                // if no daymeal found 
                $daymealInformation = new Daymeal([]); 
            }



            include './views/User/profile.php';
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }



    /**
     * Displays a specific user's profile
     *
     * @param int $userId The ID of the user to display
     * @return void
     */

    public function showProfile(int $userId): void
    {
        
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $code => $message) {
                ErrorHandler::addError($code, $message);
            }
            unset($_SESSION['errors']);
        }

        if (isset($_SESSION[APP_TAG]['connected'])) {
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $idUrl = $_GET['id'];

                if ($idUrl == $_SESSION[APP_TAG]['connected']['id'] || $_SESSION[APP_TAG]['connected']['role'] == 2) {
                    $userModel = new UserModel();
                    $userData = $userModel->getOneProfil($userId);
                    $user = new User($userData);
                } else {
                    ErrorHandler::addError('auth', "Cette page ne vous concerne pas !");
                    $errors = ErrorHandler::getErrors();
                    $_SESSION['errors'] = $errors;
                    header('Location: index.php?ctrl=user&action=showProfile&id=' . $_SESSION[APP_TAG]['connected']['id']);
                    exit;
                }
            }
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }


        include './views/User/userProfile.php';
    }


    /**
     * Handles user logout process
     *
     * @return void
     */
    public function logout(): void
    {
        if (isset($_GET['action']) && $_GET['action'] == 'logout') {
            unset($_SESSION[APP_TAG]['connected']);
            session_destroy();
            session_start();

            $_SESSION['page'] = 'Connexion';

            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }


    /**
     * Displays the user profile form
     *
     * @return void
     */
    public function displayFormProfil(): void
    {
        
        if (isset($_SESSION['errors'])) {
            foreach ($_SESSION['errors'] as $code => $message) {
                ErrorHandler::addError($code, $message);
            }
            unset($_SESSION['errors']);
        }

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            if (isset($_SESSION[APP_TAG]['connected'])) {
                $idUrl = $_GET['id'];
                $modelUser = new UserModel;
                $dataUser = $modelUser->getOneUser($idUrl);
                $user = new User($dataUser);

                $healthdataModel = new HealthdataModel();
                $healthdataData = $healthdataModel->getAllHealthdataByUser($idUrl);
                $healthdata = new Healthdata($healthdataData);

                include './views/User/formUserAccount.php';
            } else {
                ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=user&action=displayFormConnexion');
                exit;
            }
        } else {

            include './views/User/formUserAccount.php';
        }
    }



    /**
     * Handles user account creation
     *
     * @return void
     */

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                $userData = [
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'email' => $_POST['email'],
                    'pwd' => $_POST['pwd'],
                    'confirmPwd' => $_POST['confirmPwd'],
                    'birthday' => $_POST['birthday'],
                    'sexe' => $_POST['sexe'],
                    'actualWeight' => $_POST['actualWeight'],
                    'height' => $_POST['height']
                ];

                $modelUser = new UserModel();
                $result = $modelUser->createUser($userData);

                if ($result !== false) {
                    header('Location: index.php?ctrl=user&action=displayFormConnexion');
                    exit();
                }
            } catch (Exception $e) {
                ErrorHandler::addError('createAccount', $e->getMessage());
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=user&action=displayFormProfil');
                exit;
            }
        }
    }



    /**
     * Handles user profile update
     *
     * @return void
     */
    public function update(): void
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {

                    $userData = [
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'email' => $_POST['email'],
                        'pwd' => $_POST['pwd'],
                        'confirmPwd' => $_POST['confirmPwd'],
                        'birthday' => $_POST['birthday'],
                        'sexe' => $_POST['sexe'],
                        'actualWeight' => $_POST['actualWeight'],
                        'height' => $_POST['height']
                    ];

                    $modelUser = new UserModel();
                    $result = $modelUser->updateUser($_POST['id'], $userData);

                    if ($result !== false) {
                        header('Location: index.php?ctrl=user&action=showProfile&id=' . $_POST['id']);
                        exit();
                    } else {
                        throw new Exception("Erreur lors de la mise à jour du user");
                    }
                } catch (Exception $e) {
                    ErrorHandler::addError('updateProfil', "Une erreur est survenue lors de la mise à jour du profil");
                    $errors = ErrorHandler::getErrors();
                    $_SESSION['errors'] = $errors;
                    header('Location: index.php?ctrl=user&action=action=showProfile&id=' . $_POST['id']);
                    exit;
                }
            }
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }
}
