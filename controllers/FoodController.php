<?php

class FoodController
{

    private function sanitizeAndValidateData($data)
    {
        $cleanData = [];
        $cleanData['namefood'] = htmlspecialchars($data['namefood']);
        $cleanData['proteines'] = filter_var($data['proteines'], FILTER_VALIDATE_FLOAT);
        $cleanData['lipides'] = filter_var($data['lipides'], FILTER_VALIDATE_FLOAT);
        $cleanData['glucides'] = filter_var($data['glucides'], FILTER_VALIDATE_FLOAT);
        $cleanData['calories'] = filter_var($data['calories'], FILTER_VALIDATE_FLOAT);

        return $cleanData;
    }

    public function index() : void
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {
            $modelFood = new FoodModel;
            $dataFood = $modelFood->getAllFood();

            if (!empty($dataFood)) {
                if (isset($dataFood[0]) && is_array($dataFood[0])) {

                    foreach ($dataFood as $data) {
                        $foods[] = new Food($data);
                    }
                    
                } else {
                    $foods[] = new Food($dataFood);
                }
            }

            include './views/Food/foodAll.php';
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }


    public function displayFormFood() : void
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

                $modelFood = new FoodModel;

                $dataFood = $modelFood->getOneFood($idUrl);
                $food = new Food($dataFood);

                include './views/Food/formFood.php';
            } else {

                include './views/Food/formFood.php';
            }
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $_SESSION['errors'] = ErrorHandler::getErrors();
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }

    public function add() : void 
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $cleanData = $this->sanitizeAndValidateData($_POST);

                $modelFood = new FoodModel();

                $result = $modelFood->addFood(
                    $cleanData['namefood'],
                    $cleanData['proteines'],
                    $cleanData['lipides'],
                    $cleanData['glucides'],
                    $cleanData['calories']
                );

                if ($result === true) {
                    header('Location: index.php?ctrl=food&action=index');
                    exit();
                } else {
                    throw new Exception("Erreur lors de l'ajout de l'aliment");
                }
            } catch (Exception $e) {
                ErrorHandler::addError('addFood', $e->getMessage());
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=food&action=displayFormFood');
                exit();
            }
        }
    }


    public function update() : void 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
            try {
                $idUrl = filter_var($_GET['id'], FILTER_VALIDATE_INT);
                if ($idUrl === false) {
                    throw new Exception("ID invalide");
                }

                $cleanData = $this->sanitizeAndValidateData($_POST);

                $modelFood = new FoodModel();
                $result = $modelFood->updateFood(
                    $idUrl,
                    $cleanData['namefood'],
                    $cleanData['proteines'],
                    $cleanData['lipides'],
                    $cleanData['glucides'],
                    $cleanData['calories']
                );

                if ($result !== false) {
                    header('Location: index.php?ctrl=food&action=index');
                    exit();
                } else {
                    throw new Exception("Erreur lors de la mise à jour de l'aliment");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: index.php?ctrl=food&action=displayFormFood&id=' . $idUrl);
                exit();
            }
        } else {
            // Gérer le cas où la méthode n'est pas POST ou l'ID n'est pas défini
            header('Location: index.php?ctrl=food&action=index');
            exit();
        }
    }

    public function search() : void 
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {
        $userInput = '%' . $_GET['searchTerm'] . '%';

        $foodModel = new FoodModel();
        $dataFood = $foodModel->getFoodBySearch($userInput);

        if (!empty($dataFood)) {
            if (isset($dataFood[0]) && is_array($dataFood[0])) {

                foreach ($dataFood as $data) {
                    $foods[] = new Food($data);
                }
                
            } else {
                $foods[] = new Food($dataFood);
            }
        }
       

        include './views/Food/foodAll.php';
    }else {
        ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette option.");
        $_SESSION['errors'] = ErrorHandler::getErrors();
        header('Location: index.php?ctrl=user&action=displayFormConnexion');
        exit;
    }
    }

    public function delete() : void 
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {
            $idUrl = $_GET['id'];
            $modelFood = new FoodModel;
            $result = $modelFood->deleteFood($idUrl);

            if ($result !== false) {
                header('Location: index.php?ctrl=food&action=index');
            } else {
                ErrorHandler::addError('delete', $e->getMessage());
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=food&action=displayFormFood');
                exit();
            }
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette option.");
            $_SESSION['errors'] = ErrorHandler::getErrors();
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }
}
