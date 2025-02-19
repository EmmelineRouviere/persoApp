<?php

class MealController
{

    /**
     * Displays the list of meals for the logged-in user.
     *
     * @param void
     * @return void
     *
     * Checks if the user is logged in, retrieves meal names and user's meals.
     * Redirects to login page if user is not connected.
     */
    public function indexUser(): void
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {

            $modelMealName = new NamemealModel;
            $dataMealName = $modelMealName->getAllNameMeal();

            foreach ($dataMealName as $data) {
                $nameMeals[] = new NameMeal($data);
            }

            $modelMeal = new MealModel;
            $dataMeal = $modelMeal->getAllMealByUser($_SESSION[APP_TAG]['connected']['id']);

            if (!empty($dataMeal)) {
                if (!is_array($dataMeal) || !isset($dataMeal[0])) {
                    $meals[] = new Meal($dataMeal);
                } else {
                    foreach ($dataMeal as $data) {
                        $meals[] = new Meal($data);
                    }
                }
            }else {
                $meals = null;
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

    /**
     * Displays details of a specific meal.
     *
     * @param void
     * @return void
     *
     * Verifies user authentication and meal ID presence in URL.
     * Fetches meal information and associated foods.
     * Redirects to login page if user is not connected.
     */
    public function show(): void
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {

            if (isset($_GET['id']) && is_numeric($_GET['id'])) {


                $idUrl = $_GET['id'];

                $modelMeal = new MealModel;
                $dataMeal = $modelMeal->getOneMeal($idUrl);

                if ($dataMeal['use_mealOwner'] == $_SESSION[APP_TAG]['connected']['id'] || $_SESSION[APP_TAG]['connected']['role'] == 2) {

                    $meal = new Meal($dataMeal);
                    $modelFood = new FoodModel;
                    $dataFood = $modelFood->getFoodByMeal($idUrl);

                    if (!empty($dataFood)) {
                        if (isset($dataFood[0]) && is_array($dataFood[0])) {

                            foreach ($dataFood as $data) {
                                $foods[] = new Food($data);
                            }
                            
                        } else {
                            $foods[] = new Food($dataFood);
                        }
                    }

                    include './views/Meal/mealShow.php';
                } else {
                    ErrorHandler::addError('auth', "Ce repas ne vous appartient pas.");
                    $errors = ErrorHandler::getErrors();
                    $_SESSION['errors'] = $errors;
                    header('Location: index.php?ctrl=meal&action=indexUser');
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

    /**
     * Displays the form for adding or editing a meal.
     *
     * @param void
     * @return void
     *
     * Checks user authentication. If an ID is provided, loads existing meal data for editing.
     * Otherwise, displays form for adding a new meal.
     * Redirects to login page if user is not connected.
     */
    public function displayFormMeal(): void
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
                $dataFoodOptions = $modelFood->getAllFood();

                foreach ($dataFoodOptions as $data) {
                    $foodOptions[] = new Food($data);
                }

                $modelMeal = new MealModel();

                $dataMeal = $modelMeal->getOneMeal($idUrl);
                $meal = new Meal($dataMeal);

                $dataFood = $modelFood->getFoodByMeal($idUrl);

                if (!is_array($dataFood[0])) {
                    $foods[] = new Food($dataFood);
                } else {

                    foreach ($dataFood as $data) {

                        $foods[] = new Food($data);
                    }
                }


                include './views/Meal/formMealEdit.php';
            } else {
                $modelFood = new FoodModel;

                $dataFoodOptions = $modelFood->getAllFood();

                foreach ($dataFoodOptions as $data) {
                    $foodOptions[] = new Food($data);
                }

                include './views/Meal/formMeal.php';
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
     * Processes the addition of a new meal.
     *
     * @param void
     * @return void
     *
     * Verifies if the request is POST.
     * Adds the meal to the database with associated foods.
     * Redirects to meal list on success, or displays an error on failure.
     */
    public function add(): void
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $modelMeal = new MealModel();

                $result = $modelMeal->addMeal(
                    $_POST['userId'],
                    $_POST['nameMeal'],
                    $_POST['descriptionMeal'],
                    $_POST['food']
                );

                if ($result !== false) {
                    header('Location: index.php?ctrl=meal&action=indexUser');
                    exit();
                } else {
                    throw new Exception("Erreur lors de l'ajout du repas");
                    header('Location: index.php?ctrl=meal&action=displayFormMeal');
                }
            } catch (Exception $e) {
                ErrorHandler::addError('meal', $e->getMessage());
                $_SESSION['errors'] = ErrorHandler::getErrors();
                header('Location: index.php?ctrl=meal&action=displayFormMeal');
                exit();
            }
        }
    }

    /**
     * Processes the modification of an existing meal.
     *
     * @param void
     * @return void
     *
     * Verifies if the request is POST.
     * Updates the meal in the database with new information.
     * Redirects to meal list on success, or displays an error on failure.
     */
    public function edit(): void
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
                    header('Location: index.php?ctrl=meal&action=indexUser');
                    exit();
                } else {
                    header('Location: index.php?ctrl=meal&action=displayFormFoodEdit');
                    throw new Exception("Erreur lors de la modification du repas");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: index.php?ctrl=meal&action=displayFormFoodEdit');
                exit();
            }
        }
    }

    /**
     * Performs a meal search.
     *
     * @param void
     * @return void
     *
     * Checks user authentication.
     * Searches for meals matching the provided search term and userId.
     * Displays search results.
     * Redirects to login page if user is not connected.
     */
    public function search(): void
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {

            $userInput = '%' . $_GET['searchTerm'] . '%';
            $userId = $_SESSION[APP_TAG]['connected']['id'];

            $mealModel = new MealModel();
            $datas = $mealModel->getMealBySearch($userInput, $userId);

            if (!empty($datas)) {
                if (isset($datas[0]) && is_array($datas[0])) {

                    foreach ($datas as $data) {
                        $meals[] = new Meal($data);
                    }
                    
                } else {
                    $meals[] = new Meal($datas);
                }
            }else{
                $meals = null; 
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

    /**
     * Deletes a specific meal.
     *
     * @param void
     * @return void
     *
     * Verifies user authentication and meal ID presence in URL.
     * Deletes the meal from the database.
     * Redirects to meal list on success.
     * Redirects to login page if user is not connected.
     */
    public function delete(): void
    {
        if (isset($_SESSION[APP_TAG]['connected'])) {

            $idUrl = $_GET['id'];
            $mealModel = new MealModel;
            $result = $mealModel->deleteMeal($idUrl);

            if ($result !== false) {
                header('Location: index.php?ctrl=meal&action=indexUser');
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
