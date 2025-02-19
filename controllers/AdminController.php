<?php

class AdminController
{


    public function indexUser()
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {
            if ($_SESSION[APP_TAG]['connected']['role'] == 2) {

                $modelUser = new UserModel;
                $dataUser = $modelUser->getAllUsers();

                foreach ($dataUser as $data) {
                    $users[] = new User($data);
                }

                include './views/User/userAll.php';
            } else {
                ErrorHandler::addError('auth', "Vous n'avez pas les droits pour accéder à cette page.");
                $errors = ErrorHandler::getErrors();
                $_SESSION['errors'] = $errors;
                header('Location: index.php?ctrl=user&action=connected');
                exit;
            }
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }


    /**
     * Deletes a user from the system if the currently connected user has sufficient privileges
     *     *
     * @return void This method does not return a value; it performs a redirect upon completion
     */
    public function deleteUser()
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {
            if ($_SESSION[APP_TAG]['connected']['role'] == 2) {

                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    $userId = $_GET['id'];
                    $modelUser = new UserModel;
                    $dataUser = $modelUser->delete($userId);

                    if ($dataUser === true) {
                        header('Location: index.php?ctrl=admin&action=indexUser');
                        exit;
                    } else {
                        ErrorHandler::addError('delete', "Impossible de supprimer cet utilisateur");
                        $errors = ErrorHandler::getErrors();
                        $_SESSION['errors'] = $errors;
                        header('Location: index.php?ctrl=admin&action=indexUser');
                        exit;
                    }
                } else {
                    ErrorHandler::addError('user', "Un identifiant user doit être donné");
                    $errors = ErrorHandler::getErrors();
                    $_SESSION['errors'] = $errors;
                    header('Location: index.php?ctrl=user&action=connected');
                    exit;
                }
            } else {
                ErrorHandler::addError('auth', "Vous n\'avez pas les droits pour accéder à cette page.");
                $errors = ErrorHandler::getErrors();
                $_SESSION['errors'] = $errors;
                header('Location: index.php?ctrl=user&action=connected');
                exit;
            }
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }



    public function indexMeal()
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {

            $modelMeal = new MealModel;
            $dataMeal = $modelMeal->getAllMeal();

            foreach ($dataMeal as $data) {
                $meals[] = new Meal($data);
            }

            include './views/Meal/mealAll.php';
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }
}
