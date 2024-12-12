<?php 

class MealController {

    public function index(){

        $modelMeal= new MealModel;
        $dataMeal = $modelMeal->getAllMeal();

        foreach ($dataMeal as $data) {
            $meals[] = new Meal($data);
        }

        include './views/Meal/mealAll.php';
    }

    public function show()
    {

        if (isset($_GET['id'])) {

            $idUrl = $_GET['id'];

            $modelMeal = new MealModel;
            $dataMeal = $modelMeal->getOneMeal($idUrl);
            $meal = new Meal($dataMeal);

            $modelFood = new FoodModel;

            $dataFood = $modelFood->getFoodByMeal($idUrl);



            if (!is_array($dataFood[0])) {
                $foods[] = new Food($dataFood);
            } else {

                foreach ($dataFood as $data) {

                    $foods[] = new Food($data);
                }
            }


            include './views/Meal/mealShow.php';
        }
    }

   public function mealOftheDay(){

        include './views/foodToday.php'; 
    }


    public function displayFormMeal(){

        if (isset($_GET['id'])) {

            $idUrl = $_GET['id'];

            // Affichage de tous les aliments dans la liste

            $modelFood = new FoodModel; 
            $dataFoodOptions = $modelFood->getAllFood();
        
            foreach ($dataFoodOptions as $data) {
                $foodOptions[] = new Food($data);
            }

            // Récupréation des informations du repas 
            $modelMeal = new MealModel();

            $dataMeal = $modelMeal->getOneMeal($idUrl);
            $meal = new Meal($dataMeal);

            // Récupération des aliments qui composent le repas 
            $dataFood= $modelFood->getFoodByMeal($idUrl); 

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
    }

    public function add(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $modelMeal = new MealModel();
    
                $result = $modelMeal->addMeal(
                    $_POST['nameMeal'],
                    $_POST['descriptionMeal'],
                    $_POST['food'] 
                );
    
                if ($result !== false) {
                    header('Location: index.php?ctrl=meal&action=index');
                    exit();
                } else {
                    throw new Exception("Erreur lors de l'ajout du repas");
                }
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: index.php?ctrl=meal&action=displayFormFood');
                exit();
            }
        }
    }


    public function edit(){

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

    public function search()
    {
        $userInput = '%' . $_GET['searchTerm'] . '%';

        $foodModel = new MealModel(); 
        $datas = $foodModel->getMealBySearch($userInput); 

        foreach ($datas as $data) {
            $meals[] = new Meal($data);
        }  

        include './views/Meal/mealAll.php';

    }


    public function delete(){

        $idUrl = $_GET['id']; 
        $mealModel = new MealModel;
        $result = $mealModel->deleteMeal($idUrl);

        if($result !== false){
            header('Location: index.php?ctrl=meal&action=index');
        }
    }

}