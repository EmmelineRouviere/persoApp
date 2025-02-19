<?php

class DaymealController
{

    public function index() {}


    public function mealOftheDay()
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {

            $daymealModel = new DaymealModel;
            $daymealData = $daymealModel->getAllByUserCurrentDay($_SESSION[APP_TAG]['connected']['id']);

            if ($daymealData !== null) {
                if (!is_array($daymealData) || !isset($daymealData[0])) {

                    // Un seul résultat
                    $daymeals[] = new Daymeal($daymealData);
                    // Plusieurs résultats
                } else {
                    foreach ($daymealData as $data) {

                        $daymeals[] = new Daymeal($data);
                    }
                }
            } else {
                // Aucun résultat trouvé
                $daymeals = null;
            }

            $daymealInformationData = $daymealModel->getInformationForCurrentDay($_SESSION[APP_TAG]['connected']['id']);

            // Vérification si les données d'information sont nulles
            if ($daymealInformationData !== null) {
                $daymealInformation = new Daymeal($daymealInformationData);
            } else {
                // Gestion du cas où il n'y a pas d'informations sur le repas du jour
                $daymealInformation = new Daymeal([]); // Ou gérer autrement selon votre logique
            }

            include './views/foodToday.php';
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
    }



    public function displayDaymealForm()
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {
            $nameMealModel = new NameMealModel;

            $namemealData = $nameMealModel->getAllNameMeal();
    
            foreach ($namemealData as $data) {
                $namemeals[] = new NameMeal($data);
            }
    
            $mealModel = new MealModel;
            $mealData = $mealModel->getAllMealByUser($_SESSION[APP_TAG]['connected']['id']);
    
            $meals = []; // Initialisez $meals comme un tableau vide
    
            if ($mealData !== null) {
                if (is_array($mealData) && !isset($mealData['mea_id'])) {
                    // Plusieurs résultats
                    foreach ($mealData as $data) {
                        $meals[] = new Meal($data); // Utilisez Meal au lieu de Daymeal
                    }
                } elseif (is_array($mealData)) {
                    // Un seul résultat
                    $meals[] = new Meal($mealData);
                }
            }
    
            include './views/Meal/daymealForm.php';
        } else {
            ErrorHandler::addError('auth', "Vous devez être connecté pour accéder à cette page.");
            $errors = ErrorHandler::getErrors();
            $_SESSION['errors'] = $errors;
            header('Location: index.php?ctrl=user&action=displayFormConnexion');
            exit;
        }
        
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $modelDaymeal = new DaymealModel();

                $result = $modelDaymeal->addDaymeal(
                    $_POST['userId'],
                    $_POST['date'],
                    $_POST['namemeal'],
                    $_POST['meal']
                );

                if ($result !== false) {
                    header('Location: index.php?ctrl=daymeal&action=mealOftheDay');
                    exit();
                } else {
                    throw new Exception("Erreur lors de l'ajout du repas");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: index.php?ctrl=daymeal&action=displayDaymealForm');
                exit();
            }
        }
    }


    public function edit()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $modelMeal = new MealModel();

                $result = $modelMeal->updateMeal(
                    $_POST['meal_id'],
                    $_POST['nameMeal'],
                    $_POST['descriptionMeal'],
                    $_POST['food']
                );

                if ($result !== false) {
                    header('Location: index.php?ctrl=meal&action=index');
                    exit();
                } else {
                    header('Location: index.php?ctrl=meal&action=displayFormFoodEdit');
                    throw new Exception("Erreur lors de l'ajout du repas");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: index.php?ctrl=meal&action=displayFormFoodEdit');
                exit();
            }
        }
    }


    public function delete()
    {

        $idUrl = $_GET['id'];
        $daymealModel = new DaymealModel;
        $result = $daymealModel->deleteDaymeal($idUrl);

        if ($result !== false) {
            header('Location: index.php?ctrl=daymeal&action=mealOftheDay');
        }
    }
}
